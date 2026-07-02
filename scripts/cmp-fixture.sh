#!/bin/zsh
# Render a WPT reftest (test + its match reference) via the gate-faithful
# renderer and produce a side-by-side diff, for local debugging.
#
# usage: scripts/cmp-fixture.sh <test-id>
#   e.g. scripts/cmp-fixture.sh css/CSS2/positioning/top-019
#
# Prints the AE metric (0 == pixel-identical) and writes:
#   /tmp/fx_<name>_{test,ref,diff,combined}.png
# Works for .html / .xht / .xhtml / .svg fixtures — the underlying
# render-fixture.php mirrors HarnessRunner, so results match the gate.
set -e
here="${0:A:h}"
root="${here:h}"
cd "$root"
id="$1"
wpt=vendor-data/wpt
render="$here/render-fixture.php"

tp=""
for e in .xht .html .htm .xhtml .svg; do [ -f "$wpt/$id$e" ] && tp="$wpt/$id$e" && break; done
[ -z "$tp" ] && { echo "test not found: $wpt/$id"; exit 1; }

ref=$(grep -oE 'rel="match" href="[^"]+"|href="[^"]+" rel="match"' "$tp" | head -1 | grep -oE 'href="[^"]+"' | sed 's/href="//;s/"//')
[ -z "$ref" ] && { echo "no match ref"; exit 1; }
rp=$(cd "$(dirname "$tp")" && realpath "$ref" 2>/dev/null)

stem=/tmp/fx_$(basename "$id")
php "$render" "$tp" "${stem}_test.png" >/dev/null 2>&1
php "$render" "$rp" "${stem}_ref.png" >/dev/null 2>&1
ae=$(compare -metric AE -fuzz 1% "${stem}_test.png" "${stem}_ref.png" "${stem}_diff.png" 2>&1)
echo "test: $tp"
echo "ref:  $rp"
echo "AE: $ae"
convert "${stem}_test.png" -bordercolor blue -border 2 "${stem}_ref.png" -bordercolor green -border 2 "${stem}_diff.png" -bordercolor red -border 2 +append "${stem}_combined.png" 2>/dev/null
echo "combined: ${stem}_combined.png (test=blue | ref=green | diff=red)"
