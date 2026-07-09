# css → 90% census (2026-07-08)

Full `css/**` WPT run (settler-off). **css 14,886 / 21,270 in-scope = 69.99%.**
1.0.0 is gated on ≥90% across all four buckets; css is the sole blocker
(html 96.6 / svg 94.3 / mathml 99.4 all clear). See `project_release_gate` memory.

**6,384 in-scope fails. Need to clear ~4,257 of them to reach 90% (19,143 pass).**

## Blind-spot map — fails by css sub-bucket

| Sub-bucket | fails | Kind |
|---|---|---|
| **CSS2** | **1113** | core layout edge cases (see breakdown) |
| **css-grid** | **666** | big layout engine, partial |
| **css-writing-modes** | **637** | vertical modes (Phase B) |
| **css-flexbox** | **552** | big layout engine, partial |
| **css-transforms** | 355 | transform-origin 81 / matrix 56 / transform-box 30 |
| **css-multicol** | 269 | **whole feature ~all-failing → blind spot** |
| **css-sizing** | 269 | aspect-ratio + intrinsic |
| **css-masking** | 216 | **clip-path 120 + mask-image 91 → blind spot** |
| css-backgrounds | 176 | |
| **css-shapes** | 170 | **shape-outside → likely blind spot** |
| **css-gaps** | 155 | **gap decorations (new) → likely blind spot** |
| css-images | 148 | object-fit/view-box, image-set |
| **css-anchor-position** | 148 | **new feature → likely blind spot** |
| css-text | 145 | |
| css-contain | 128 | container queries / contain |
| css-overflow | 125 | |
| css-position | 109 | |
| css-inline | 109 | |
| css-values / motion / css-shadow / css-page / css-tables | 93 / 90 / 88 / 86 / 74 | |
| (long tail: borders, box, viewport, ui, align, fonts, …) | <40 each | |

## CSS2 (1113) — the core-layout blind spot

Not an unimplemented feature — these are edge-case fails scattered through the
*implemented* core, so high correctness value but no single bulk fix:

| CSS2 area | fails |
|---|---|
| positioning | 139 |
| margin-padding-clear | 133 |
| floats-clear | 126 |
| tables | 120 |
| normal-flow | 119 |
| backgrounds | 64 |
| css1 | 59 |
| floats | 56 |
| box-display | 50 |
| text / bidi-text / linebox / borders / fonts | 36 / 36 / 33 / 29 / 23 |

## Two kinds of blind spot

1. **Whole-feature gaps (~958 fails) — potential BULK wins** if implementing the
   feature flips many at once (like earlier cluster wins): `css-multicol` (269,
   ~all failing), `css-masking` (216: clip-path + mask-image), `css-shapes`
   (170), `css-gaps` (155), `css-anchor-position` (148). **Verify each is
   genuinely unimplemented vs. partial before committing** — an unimplemented
   feature is the highest ROI-per-effort on this list.
2. **Deep edge-case fields — grind, high correctness value:** `CSS2` (1113),
   `css-grid` (666), `css-flexbox` (552), `css-writing-modes` (637). These are
   implemented engines with hundreds of edge cases each; progress is steady, not
   bulk.

## Path to 90% (+4,257)

The top ~9 sub-buckets ≈ the whole gap: CSS2 (1113) + grid (666) + writing-modes
(637) + flexbox (552) + transforms (355) + multicol (269) + sizing (269) +
masking (216) + shapes (170) = **4,247**. So reaching 90% essentially means
clearing (most of) these nine. Ordered attack:

1. **Confirm + attack the whole-feature blind spots first** (multicol, masking,
   shapes, gaps, anchor-position) — highest ROI-per-effort IF unimplemented.
   Each needs a "is it implemented?" probe (grep + one fixture) before a plan.
2. **css-writing-modes** — already in flight (Phase B; increment 1 shipped +8);
   continue increments 2–4 (`docs/plans/phase-b-vertical-inline.md`).
3. **grid + flexbox** — the two biggest layout engines; census-drill each into
   sub-areas (as CSS2 was) to find the densest sub-clusters.
4. **CSS2** — steady grind through positioning / floats-clear / tables /
   normal-flow; highest correctness value, no bulk fix.
5. **transforms** (transform-origin 81, matrix 56) + **sizing** (aspect-ratio).

Re-run this census (`wpt run --filter='css/**' --show-fails`) after each major
push to re-rank. Raw fail list this run: captured to /tmp/css_census.txt.

## Blind-spot probe verdict (2026-07-08) — NO easy bulk wins

Probed all five (grep for the feature's core impl + sampled failing-test AEs).
The bulk-win hypothesis is **mostly FALSE** — the codebase is more complete than
fail-counts implied. Corrected classification:

| Feature | fails | Verdict | Nature |
|---|---|---|---|
| clip-path | 120 | **IMPLEMENTED** (`Painter::applyClipPath`) | accuracy grind — rect/xywh 0.134, ellipse 0.28, SVG-clip 0.5; no <0.05 near-misses |
| shape-outside | 170 | **IMPLEMENTED** (`FloatItem`/`FloatContext` exclusions) | advanced grind — fails are shape-image/gradient shapes (0.136) |
| css-multicol | 269 | **IMPLEMENTED** (`isMultiColumnContainer`) | advanced grind — span-all / breaking / gap-decorations fail (0.18–0.63) |
| gap-decorations (css-gaps) | 155 | parsed, rules NOT drawn | moderate feature — new spec, draw row/column rule lines (0.38–0.52) |
| mask-image | 91 | **parse-only** (2 files) | feature build — compositing, hard |
| anchor-position | 148 | **registered-only** (1 file, AE 0.95) | feature build — new positioning model, big |

**Conclusion:** no "implement a missing feature → flip 150 tests cheaply" win
exists. The path to 90% is a genuine grind across implemented engines plus two
real feature builds (anchor-position, mask-image). The proven win pattern this
project (static-X +18, table-shrink +42, Phase B +8) is **find the densest
CLOSE sub-cluster inside an implemented feature and fix its one systematic bug**
— e.g. clip-path rect/xywh all at identical 0.134 (one geometry bug?), or
Phase B increments. So the right cadence is: drill the BIG buckets (grid 666,
flexbox 552, CSS2 areas) into identical-AE sub-clusters and pick those off, not
chase whole "blind-spot" features. anchor-position / mask-image are the only
true greenfield features — high count but high cost; defer unless a cheap
subset exists.

## Grid drill (2026-07-08) — css-grid 666 → sub-clusters + 2 fixes

Drilled css-grid: grid-lanes (330) · grid-items (112) · alignment (75) · subgrid
(49). grid-lanes → **auto-repeat ~80** (the biggest) and grid-items →
**z-axis-ordering ~15**.

- **auto-repeat (~80) — BLOCKED.** All failing tests use INTRINSIC tracks
  (`repeat(auto-fill, auto/max-content/minmax(intrinsic,intrinsic))`); the count
  needs measured content max-content (chicken-egg: track size ↔ count).
  `computeAutoFillCount` returns 1 for non-length tracks. A spec-correct minFloor
  patch (use a `minmax(<fixed-px>,…)` floor for the count) is **net-0** — zero
  failing tests use a fixed-px min. Deferred: needs grid intrinsic-track content
  measurement. Reverted the patch.
- **z-axis-ordering (~15) → SHIPPED +5** (commit 5072d4598). The painter walked
  raw document order; grid items with z-index (CSS Grid §4.4) now paint in
  z-index order. Flex items also z-order but negative-z on flex CONTAINERS needs
  stacking-context handling (regressed flexible-box-float) — scoped to grid,
  flex deferred. The `grid-INLINE-z-axis` variants (0.067) still fail: their
  items don't overlap correctly in our layout (a grid PLACEMENT bug, separate).

Also shipped: **clip-path rect()/xywh() +6** (commit 9c14e513b) — the painter
had no case for those shapes (returned false, no clip). css-90-push: **+11**.

Deferred grid work, by size: grid intrinsic auto-repeat count (~80), flex/grid
container stacking contexts, grid inline-axis placement (overlap). Next drill
targets by fail count: css-flexbox (552), CSS2 floats/positioning/tables.

## Flexbox drill (2026-07-08) — css-flexbox 552, NO cheap win

Drilled css-flexbox. The big clusters are all deep/blocked/unimplemented — unlike
grid (z-index paint bug) and masking (clip-path missing case), flexbox has no
clean paint-layer fix:

- **flexbox_flex + flexbox_flex-N (~77)** — the flex shorthand suite (`flex: 0 1
  N%` etc.). Moderate identical-AE clusters (0.088×2, 0.102×3, 0.133×2 = a shared
  LAYOUT offset). BLOCKED by margin-collapse-through-root (see
  `docs/plans/margin-collapse-through-root.md`, the "53 painter mystery"). Deep.
- **balance (30)** — CSS Flexbox 2 draft `flex-wrap: balance` + `flex-line-count`.
  UNIMPLEMENTED (grep: no flex-line-count handling). New feature build.
- **mbp-horiz (11), percentage-heights (14), intrinsic-size (11)** — gross layout
  offsets (~0.18); flex box-model / intrinsic sizing, not near-misses.
- **flexbox-writing-mode (14)** — Phase B adjacent (vertical flex).
- **flex-aspect-ratio-img (~20)** — aspect-ratio images in flex.

**Takeaway:** the clean census wins so far (clip-path +6, grid z-index +5) were
PAINT-layer bugs, not layout. Layout-heavy buckets (flex sizing, grid lanes) are
hard. Highest-value flexbox lever = the margin-collapse-through-root redesign
(unblocks ~77 flexbox_flex + broad CSS2/positioning) but it's the documented deep
dead-end. Recommend next drill target **CSS2** (floats/positioning/tables/
backgrounds — implemented core, likely more paint/geometry identical-AE bugs)
over more flexbox.

## CSS2 drill (2026-07-08) — the "applies-to" cluster is the BIGGEST lever (199 fails)

CSS2 backgrounds: many are `reftest-wait`+JS dynamic (background-root-1xx, AE=1.0)
— settler-blocked false fails, skip. The real find is bucket-spanning:

**"applies-to" tests: 199 census fails, one systematic TABLE bug.** These CSS2.1
tests check a property (border-*, background-*, width, etc.) applies to each
`display` type; they share a template and the shared ref `ref-filled-black-96px-
square`. A dominant sub-cluster sits at IDENTICAL AE 0.0381759 (~13 of a 40-sample
→ likely 50+), plus tight clusters at 0.044/0.048/0.058.

ROOT CAUSE (confirmed on `border-right-width-applies-to-001`, display:table-row-
group with border-right:1in): the test's `display:table` div renders at **w=612
(full container)**; it must **shrink-to-fit** to its content (~0 for empty cells,
+96px border) per CSS 2.1 §17.5.2. Result: our 96px black square lands at the
RIGHT (x≈516); the ref expects it at the LEFT (x≈0). Diff = two non-overlapping
squares ≈ 0.038, identical across every applies-to test using that display type.

The table shrink-to-fit mechanism EXISTS (shipped +42, `measureTableMinMax` +
shrink path, task #7) but is NOT triggering for these block-level `display:table`
divs. Fix = make block-level auto-width tables use shrink-to-fit width (not fill
the container) — extend/unblock the existing path.

### SHIPPED (2026-07-09) — +10 net css, zero regressions

`blockNeedsShrinkToFit` (BlockLayout.php:~5387) gated table shrink-to-fit on
`measureTableMinMax()['hasContent']` — the deliberate guard that kept *empty*
grids filling the container (the "scaffold table" carve-out). Removed it: an
auto-width block table now **always** shrink-to-fits, even when empty (an empty
auto table is 0-wide per §17.5.2, so a row-group's right border lands at the
table's left edge = the applies-to reference).

Measured **paired same-env before/after** (`wpt run --filter` + stash):
- `css/**`: pass 14976→14986 = **+10, fail −10, total constant** (no regression)
- `css/CSS2`: +6 · `css/css-tables`: +1 (both paired, no regression)

The +10 is smaller than the 199-fail cluster implied because most applies-to
variants carry *secondary* bugs (only the table-geometry ones flip on the square
position); the cluster is real but not monolithic. Unit fallout: 4 tests encoded
the old empty-fill (`testTable*` split/colspan/align used empty cells as a lazy
600px trigger) — given real `width:600px` so they still exercise column
distribution; `…AllEmptyCellsFallsBackToEqualShare` repurposed →
`…ShrinksToZero`. gates: lint+PHPStan clean, 980 html-to-pdf tests green.
Baseline css floor ratcheted 14886→14896 (relative +10). css-90-push now +21.

Remaining applies-to tail = the secondary-bug variants (border rendering, bg
positioning on non-block display types) — separate drills, no single lever.
