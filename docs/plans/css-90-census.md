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
