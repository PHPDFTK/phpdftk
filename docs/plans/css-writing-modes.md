# css-writing-modes pass

Raise `css-writing-modes` from **394 / 1057 in-scope (37%)** by attacking the two
feature-sized blockers behind almost all of the fails. This is a dedicated
feature area, not a lever — every cluster below needs real orthogonal-flow or
vertical-inline support, so it wants a focused pass (or two), not a quick fix.

Measured settler-off via `wpt run --filter='css/css-writing-modes/**'` (Ahem
loads — never use `--root=subdir`, it drops Ahem; see `reference_wpt_gate`).

## Fail landscape (by cluster)

| Cluster | ~fails | Nature | Blocked on |
|---|---|---|---|
| `abs-pos-non-replaced-{vrl,vlr}` (+ `-icb-`) | **~234** | orthogonal abspos: element `writing-mode:vertical-*` in a horizontal CB, over-constrained insets | **A. orthogonal abspos** |
| `block-flow-direction-{vrl,vlr,srl,slr}` | ~48 | block-level + inline-block flow in vertical modes (AE ~0.78, gross) | **B. vertical inline layout** |
| `sizing-orthog-*` (`vlr-in-htb`, `prct-*`) | ~40 | orthogonal-flow intrinsic sizing | B (+ orthogonal sizing) |
| `line-box-direction-{vrl,vlr,srl,slr}` | ~36 | line box direction in vertical modes | **B** |
| `text-indent-{vrl,vlr}`, `text-align-{vrl,vlr}` | ~28 | inline alignment in vertical modes | **B** |
| `ch-units-vrl`, `margin-collapse-vlr`, `available-size` | ~34 | mixed | B / misc |
| `wm-propagation-body*` | ~16 | writing-mode body→root propagation — but **JS dynamic-change** | settler/JS (skip) |

Two root efforts cover the bulk: **A. orthogonal abspos** (~234, biggest single
count) and **B. vertical inline layout / "Phase 4"** (~150 across block-flow,
line-box, text-align/indent, sizing-orthog). Per `project_writing_modes_state`
memory, Phase 4 (vertical inline layout) was already flagged as the next
high-ROI writing-modes work.

## A. Orthogonal absolute positioning (~234)

These are the classic green-covers-red grid tests (`bg-red-3col-3row` +
green overlay + "FAIL" marker), systematically varying inset / margin / auto
combinations. The abspos element is `writing-mode: vertical-rl/lr` inside a
horizontal-tb containing block.

**Symptom (oracle-confirmed vs Chromium):** the green box lands at the wrong
inline position — e.g. `abs-pos-non-replaced-vrl-216`, ours pins the green
square to the far **left** (doesn't cover the FAIL marker); Chromium centres it.
AE ~0.03–0.04 — close, one positioning error, so a correct axis/static-position
fix should fan out across the ~234.

**Where:** `packages/html-to-pdf/src/Layout/BlockLayout.php` —
`resolveAbsoluteOffsetsVertical` (~2332) handles a vertical *containing block*;
the missing case is a vertical *element* in a horizontal CB (orthogonal). The
gap:
- Static position (`left`/`right` auto) for an orthogonal abspos uses the CB's
  inline axis + the element's block-flow start (vertical-rl block-start = right).
- Shrink-to-fit width (block size of a vertical element = physical width) from
  content, under the element's own writing mode.
- §10.6.4 over-constraint resolution mapped to the CB's axes, not the element's.

Prior art: commit `ac9468807` ("abspos axis-mapping for vertical-mode containing
blocks") did the CB-vertical case; this is the orthogonal-element case.

**ROI: highest** (~234 tests, close AE, plausibly one systematic fix). Start
here.

## B. Vertical inline layout ("Phase 4", ~150)

Block-flow-direction, line-box-direction, text-align/indent-in-vertical, and
much of sizing-orthog need **inline content laid out along a vertical axis** —
line boxes that advance top-to-bottom (or bottom-to-top) with the block axis
horizontal. Today `InlineLayout` is horizontal-only; `BlockLayout` has a partial
vertical *block* stack (`stackChildrenListVertical`) but inline runs inside a
vertical block still flow horizontally, so `block-flow-direction` with
inline-block content is ~0.78 (gross).

This is the larger build: teach `InlineLayout` (and the atomic path — see
`docs/plans/writing-mode-atomics.md`) to advance along the block-flow axis
determined by `writing-mode`. Big, but unblocks ~150 across several clusters.

## Recommended order

1. **Orthogonal abspos (A)** — biggest count, closest AE, likely one root fix.
   Oracle each candidate; stash-based before/after on
   `css-writing-modes` + `css-position` (abspos spillover both ways).
2. **Vertical inline layout (B)** — a proper Phase-4 feature; fold in
   `writing-mode-atomics.md`. Validate against `block-flow-direction`,
   `line-box-direction`, `text-align/indent-*`.
3. Skip `wm-propagation-body*` (JS dynamic-change, settler-blocked).

## Validation

- Oracle (`scripts/oracle-render.sh chromium`) — these are green-covers-red, so
  box geometry is what matters; the browser's default-font instruction text is a
  confound, compare the coloured squares.
- `wpt run --filter='css/css-writing-modes/**' --json` before/after (stash-based,
  Ahem-loaded). Watch `css-position` and `css-sizing` for spillover.

## References

- `BlockLayout.php`: `resolveAbsoluteOffsetsVertical` (~2332),
  `resolveAbsoluteOffsets*` (~2191), `stackChildrenListVertical`, `WritingMode`.
- `InlineLayout.php`: horizontal-only line fitter (the Phase-4 target).
- `docs/plans/writing-mode-atomics.md` — the atomic-box slice of B.
- `project_writing_modes_state` memory — phases 1+3 done, Phase 2 partial,
  Phase 4 (this) flagged high-ROI.
- Commit `ac9468807` — CB-vertical abspos prior art.
