#!/usr/bin/env bash
#
# Report WPT in-scope coverage % per top-level corpus, running each corpus
# CONCURRENTLY (not one-after-another). Settler is forced OFF for
# determinism, matching the wpt:gate methodology.
#
# Usage:
#   scripts/wpt-coverage.sh                 # html svg mathml css (default)
#   scripts/wpt-coverage.sh html css        # a subset
#
# Coverage % = pass / inScopeTotal (skipped/out-of-scope excluded), the same
# `inScopePassRate` the harness reports. An aggregate row sums the buckets.
#
# IMPORTANT: uses `--filter=<corpus>/**` with the DEFAULT root
# (vendor-data/wpt), NOT `--root=vendor-data/wpt/<corpus>`. Many fixtures pull
# Ahem via an ABSOLUTE `<link href="/fonts/ahem.css">`, which only resolves
# when the sandbox root is the corpus root. Passing a sub-directory as --root
# moves the sandbox root and silently drops Ahem, so all Ahem text renders
# blank and coverage is badly understated. Same methodology as wpt-scoreboard.
set -uo pipefail
here="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
root="$(dirname "$here")"
cd "$root"

corpora=("$@")
if [ ${#corpora[@]} -eq 0 ]; then
    corpora=(html svg mathml css)
fi

wpt=packages/wpt-harness/bin/wpt
tmp="$(mktemp -d)"
trap 'rm -rf "$tmp"' EXIT

# Launch every corpus in parallel.
pids=()
for c in "${corpora[@]}"; do
    (
        WPT_DISABLE_DOM_SETTLER=1 "$wpt" run --filter="$c/**" --json \
            > "$tmp/$c.json" 2> "$tmp/$c.err"
        echo $? > "$tmp/$c.rc"
    ) &
    pids+=($!)
done
echo "running ${#corpora[@]} corpora in parallel: ${corpora[*]} ..." >&2
wait "${pids[@]}"

# Aggregate + report.
python3 - "$tmp" "${corpora[@]}" <<'PY'
import json, sys, os
tmp = sys.argv[1]
corpora = sys.argv[2:]
rows = []
tot_pass = tot_scope = 0
for c in corpora:
    p = os.path.join(tmp, f"{c}.json")
    try:
        d = json.load(open(p))
    except Exception as e:
        rows.append((c, None, None, None, f"ERROR ({e})"))
        continue
    pas = d.get("pass", 0)
    scope = d.get("inScopeTotal", 0)
    rate = d.get("inScopePassRate", (pas / scope if scope else 0.0))
    tot_pass += pas
    tot_scope += scope
    rows.append((c, pas, scope, rate, ""))

w = max([len(c) for c in corpora] + [9])
print(f"\n{'corpus'.ljust(w)}  {'pass':>7}  {'in-scope':>8}  {'coverage':>9}")
print("-" * (w + 30))
for c, pas, scope, rate, err in rows:
    if err:
        print(f"{c.ljust(w)}  {err}")
    else:
        print(f"{c.ljust(w)}  {pas:>7}  {scope:>8}  {rate*100:>8.2f}%")
print("-" * (w + 30))
agg = (tot_pass / tot_scope * 100) if tot_scope else 0.0
print(f"{'TOTAL'.ljust(w)}  {tot_pass:>7}  {tot_scope:>8}  {agg:>8.2f}%\n")
PY
