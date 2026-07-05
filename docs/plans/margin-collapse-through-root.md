# Margin collapse through the root

Fix the block-layout bug where a first in-flow child's top margin that collapses
*through* its ancestors to the root is silently dropped, mis-positioning the
content. This is the vertical blocker behind the `flexbox_flex-*` suite and a
broad set of first-child-margin reftests.

## Why

CSS 2.2 §8.3.1 — adjoining margins collapse, and a box's top margin collapses
with its first in-flow child's top margin when nothing (border, padding,
clearance, inline content) separates them. This can cascade up through
`html` / `body` to the root, where the collapsed margin becomes the offset from
the viewport to the first content.

We propagate the margin but never apply it to position. **Oracle-confirmed**
(Chromium via `scripts/oracle-render.sh`):

```
body { margin: 8px }  #a { margin-top: 40px; height: 50px; background: blue }
```
Collapsed top margin = `max(8, 40) = 40`, so `#a`'s box top is at **y=40**.

| Engine | `#a` top |
|--------|----------|
| Chromium (truth) | **40** |
| ours | **10** |

We lose ~30px of the collapsed margin. Verified this is a **real code
regression, not env drift** (see `git bisect` note below — reproduces at the
baseline commit too).

## Root cause

`packages/html-to-pdf/src/Layout/BlockLayout.php`, `layoutBlock()` first-child
collapse (~line 1103–1132). It correctly propagates the child's margin onto the
parent's own `margin-top`:

```php
$extra = max(0.0, $childTopMargin - $geo->marginTop);
if ($extra > 0.0) {
    $geo->marginTop += $extra;
    $geo->y -= 0.0;         // ← NO-OP. The bug.
}
```

`$geo->y` was set earlier (line ~895, `originY + marginTop + borderTop +
paddingTop`) using the **pre-collapse** margin. When `$extra` grows the margin,
the box's position is never updated — the collapsed margin lands on `marginTop`
but never offsets anything.

## Dead-ends (do not repeat)

Both attempts made the **geometry correct** but broke rendering / tests, and both
hit the same deeper mystery.

1. **`$this->shiftSubtree($box, $extra)` in place of the no-op.**
   Geometry reaches y=40 for the repro (and nested-case hand-traces are
   consistent, no double-count). But: render lands at **y=53** (overshoot) and
   1 unit test breaks (`RendererTest::testNamedPageOverlaysOnDefaultPageBackground`).
   The shift happens *inside* the child's layout, after the parent already
   computed its cursor / content-height / page mapping.

2. **Drift correction in the stacking loop** (`stackChildrenList`, after
   `layoutBox(child)`): re-seat BlockBox/AnonymousBlockBox children at
   `cursorY + finalMarginTop + border + padding`. Result: repro **still** y=53,
   and **10 unit failures** (the drift fires for *every* box whose first-child
   margin collapsed through — extremely common — conflicting with the existing
   sibling-collapse at ~6626 and first-child handling at ~1103).

### The "53" mystery — solve this FIRST

With **both** approaches the *geometry* reaches y=40 (verified by instrumenting
`Painter::paintBox`) but the *render* is y=53 (+13). So there is a
painter / page-mapping discrepancy **independent of layout geometry** — shifting
the body down perturbs something in the `geometry → PDF y → raster` pipeline.
Until this is understood, no layout fix will render correctly. First task:
instrument the Painter's geometry→PDF y-conversion for a shifted body and find
the +13.

## Recommended approach

The single-pass ordering (parent positions children before their margins
finalize) is the core obstacle. Two viable designs:

- **Margin-collapse pre-pass.** Before positioning any child, walk the subtree
  and compute each box's collapsed `margin-top` / `margin-bottom` (first-child
  through-collapse + sibling collapse) so the stacking loop positions with final
  margins. Cleanest, but a new pass over the block tree.
- **Parent re-seat, done right.** Keep single-pass but make the parent
  authoritative: position each child *after* `layoutBox` using its final margin,
  and fold the delta into the cursor / content-height / page accounting in the
  same place (not just `shiftSubtree`). The dead-ends failed because they shifted
  the box without updating the parent's flow state.

Either way, the painter/page "53" spike is a prerequisite.

Root absorption: at `html` (the `isRoot` skip, ~line 1101) the propagated margin
should position the first child at the collapsed offset (viewport-absorbed),
*not* be dropped — but only after the general case works, to avoid the negative-
margin push-off-page the current skip guards against.

## Impact

- Unblocks the `flexbox_flex-*` suite's vertical offset (see
  `feedback_flex_grid_threads` memory / the shrink + margin fixes already
  shipped).
- Broad: any first-child-margin reftest (very common). Likely a meaningful WPT
  delta across `CSS2`, `css-flexbox`, positioning.

## Validation

- Oracle each candidate against Chromium (`scripts/oracle-render.sh chromium`).
- Full `html-to-pdf` unit suite (the dead-ends broke 1 and 10 respectively — a
  clean fix breaks 0, or updates only tests that encoded the bug, with the
  update justified).
- Stash-based before/after on `CSS2` + `css-flexbox` via
  `wpt run --filter=… --json` (NOT `--root=subdir` — that drops Ahem; see
  `reference_wpt_gate` memory).

## References

- `packages/html-to-pdf/src/Layout/BlockLayout.php` — `layoutBlock` (~615),
  first-child collapse (~1103–1132), `geo->y` set (~895), `stackChildrenList`
  (~6503), sibling collapse (~6626).
- `feedback_margin_collapse_root` memory — the two dead-ends in detail.
