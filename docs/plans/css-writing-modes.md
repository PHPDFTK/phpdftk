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

### PARTIAL FIX SHIPPED (2026-07-04, commit 2f3f5b513): +18 via inline static-X

DERIVED the static-position rectangle and shipped the fix. Key spec principle
(CSS Writing Modes §7.4): **sizing uses the ELEMENT's writing mode; positioning
uses the CONTAINING BLOCK's.** So the element's size already resolves in its own
mode (vertical-rl: height=inline-size, width=block-size) — that was already
correct. The bug was the *static position*: the CB content is
`1 2 34<span abspos>`, and the span's static INLINE position is the end of the
preceding text's last line (Ahem 80px, wraps at 320 → line 2 "34" → x=160), NOT
the CB's inline-start (0). We computed static-Y that way but used the CB origin
for X. Added `inlineStaticPositionX` (mirror of `inlineStaticPositionY`, rightmost
fragment edge of the preceding line box). Result: **css-writing-modes 394→412
(+18), css-position flat, 0 regressions.** NOT writing-mode-specific — it's a
general inline-abspos static-X fix.

REMAINING (~216 of the cluster still fail): the abspos static-Y. Post static-X
the subset is 40/256; the 216 fails split into TWO sub-clusters by WHERE the
`writing-mode` sits (confirmed by reading the markup + instrumenting the
dispatch on `parentWritingMode`):

- **CB-vertical** (e.g. `vrl-056`: `writing-mode:vertical-rl` on the CB, span
  inherits) → the div lays its children via `stackChildrenListVertical`, whose
  abspos branch (~6802) calls `resolveAbsoluteOffsets` → `…Vertical`.
- **Orthogonal** (e.g. `vrl-224`: `writing-mode` on the SPAN only, CB
  horizontal) → `stackChildrenList` + the horizontal path.

### static-Y DIAGNOSED (2026-07-05): it's a MULTI-PASS OVERRIDE, not offset math

For CB-vertical `vrl-056` (`top:auto; bottom:1em; height:1em`, cbH=320): a clean
single-run trace (log both resolve returns + the Painter geometry) shows
`resolveAbsoluteOffsetsVertical` fires **once** and returns **dy=160**
(`320 − 80 − outerH80`) with the box laid at `gy=68` (the CB top) — i.e. the
offset math is CORRECT (box should shift to CB+160 = 228). But the Painter sees
**y=212** = the inline-static-Y (block-start of "1 2 34"'s last line). So a
**later layout pass re-seats the span at its static position, discarding the
abspos shift.** The fix is in the multi-pass ordering / preventing the
re-seat — NOT in the §10.6.4/§10.3.7 offset resolution (which is right).
RULED OUT: threading the CB's `writing-mode` onto the abspos context via
`$absCb->withParentWritingMode($wm)` in `stackChildrenListVertical` — no-op
(AE unchanged), so the dispatch was already vertical.

### OVERRIDE-PASS HUNT (2026-07-05): found the exact pass, but two more problems

Traced the span's `geometry.y` through every mutation (each `layoutBox` /
`shiftSubtree` / paint) in one run:

```
layoutBox originY=68 gy=0            (laid at CB top)
shiftSubtree dy=160  gy=68  -> 228   (correct abspos offset, from resolveAbsoluteOffsetsVertical)
shiftSubtree dy=-16  gy=228 -> 212   (THE OVERRIDE — backtrace: layoutBlock:1123)
PAINT gy=212
```

**The override is the FIRST-CHILD MARGIN-COLLAPSE cascade** (`layoutBlock`
~1103–1130): when the CB's first in-flow child has a positive top margin it
shifts all following siblings up by `-childTopMargin` (~1122). The abspos span
is nested inside the anonymous block wrapping the "1 2 34" text, so
`shiftSubtree` drags it along (CSS 2.1 §8.3.1/§9.3 — an out-of-flow box's
position is CB-relative and must NOT ride an in-flow margin-collapse shift).

TWO blockers remain, both confirmed empirically:
1. **The naive fix is too broad.** Adding `skipOutOfFlow` to `shiftSubtree`
   (skip out-of-flow descendants in the margin-collapse cascade) is unit-safe
   (977) and net-0 on the cluster, but **regresses `css-position/position-
   absolute-center-001`** — an abspos whose CB is *inside* the shifted subtree
   SHOULD ride along. The correct fix is **CB-AWARE**: skip an out-of-flow
   descendant only when its containing block is NOT within the shifted subtree.
2. **Even with Y fixed, the CB-vertical rendering is broadly wrong.** Measured
   our-test vs ref green (page px) for `vrl-056`: ours `x=0..274` (274px wide!)
   vs ref `x=213..319` (106px, right side). So the whole vertical+abspos+rtl
   *rendering* (not just the abspos Y) is off — the green content is mis-sized
   and mis-placed along X too. The CB-vertical sub-cluster needs the vertical-
   mode inline/abspos rendering fixed (overlaps Phase B), not just the Y offset.

So the override-pass hunt SUCCEEDED (exact bug: margin-collapse cascade at
~1122 drags nested abspos), but flipping the cluster needs (a) the CB-aware
shiftSubtree skip AND (b) the broader vertical-mode rendering. Neither shipped
— the naive skip is net-negative.

Also (lower priority): `inlineStaticPositionX` returns null in the NO-lineBox
path (`layoutAtomicOnly` produces no line boxes), so a preceding inline-block
without a font doesn't contribute — real WPT uses Ahem so it's fine.

### Push-in findings (2026-07-04) — dispatch is necessary but NOT sufficient

Investigated `abs-pos-non-replaced-vrl-216` (ref: green box at `(160,160) 80×80`;
ours `(0,212)`). Concrete state:

- **Size is already correct** (80×80). The bug is purely *position*.
- **Axis dispatch must key on the ELEMENT's writing mode, not the CB's.**
  `resolveAbsoluteOffsets` (~2197) dispatches to `…Vertical` only when
  `parentWritingMode->isVertical()`. Changing it to
  `WritingMode::fromStyle($child->style)->isVertical() || $cbWm->isVertical()`
  correctly routes this orthogonal element to the Vertical path (confirmed
  reached, `elemVert=Y`) and is spec-correct — BUT **net-0** on the cluster
  (394→394, 0 fixed / 0 regressed) and unit-safe. So dispatch alone changes
  nothing; do not ship it standalone.
- **The real blocker: orthogonal INLINE-LEVEL abspos static position.** The
  element is `display:inline` + `position:absolute` (blockified). With
  `left/right/width` all `auto`, the block-axis (physical X, horizontal) uses
  the STATIC position; the correct x is 160 but our static position gives 0, and
  the Vertical path's `dx` (2350) is also 0 for auto left/right. The y is also
  wrong (212 vs 160) — the inline-axis over-constraint (top:2em wins, ignore
  bottom) isn't being applied because the static-position + offset composition
  for an inline-level orthogonal abspos is tangled (see the inline static-
  position path at ~6511/6579, `inlineStaticPositionY` ~6695).
- **x=160 is the crux** and is genuinely subtle: derive the static-position
  rectangle for an orthogonal (vertical-rl-in-horizontal-CB) inline abspos per
  CSS Position 3 §3 / Writing Modes §7 before coding. It is NOT simply 0 (inline
  start) nor the CB centre.

So the fix is: (a) dispatch on element WM [done, trivial], (b) compute the
orthogonal inline-abspos static-position rectangle correctly, (c) make the
Vertical path's offset compose with that static position. (b) is the hard part
and where the ~234 will actually flip.

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
