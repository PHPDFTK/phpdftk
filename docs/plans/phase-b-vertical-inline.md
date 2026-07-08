# Phase B — vertical-mode inline rendering

Make inline formatting contexts lay out and paint along a **vertical** axis for
`vertical-lr` / `vertical-rl` / `sideways-lr` / `sideways-rl`. This is the single
biggest remaining css-writing-modes unblock: ~84 gross fails (line-box-direction,
block-flow-direction) plus ~28 near-miss fails (text-indent, text-align), and it
also unblocks the CB-vertical **abspos** cluster (the mis-shaped green in
`docs/plans/css-writing-modes.md` is this same bug — vertical content painted
horizontally). Scale: ~150 tests across css-writing-modes, plus spillover into
css-sizing orthogonal and css-position.

## Current state (mapped 2026-07-06)

- **Layout has a Phase-4 SCAFFOLD, not real vertical flow.** `InlineLayout`
  (`packages/html-to-pdf/src/Layout/InlineLayout.php`) lays every IFC out
  HORIZONTALLY. For `vrl`/`sideways-rl` only, `applyVerticalLineShift` (~368)
  shifts whole lines rightward so single-line atomic content lands at the
  block-start edge. Glyphs are **not** transposed or rotated. `vlr` gets no
  transform at all.
- **The fragment model is inline-axis-only.** `InlineFragment` (readonly) carries
  `x` (inline position within the line) + `width`; the block position is the
  shared `LineBox.y`. There is no per-fragment vertical position, so a fragment
  can't independently express "inline offset = vertical, block offset =
  horizontal" without a model change or a paint-time transform.
- **The painter has NO vertical-text support.** `Painter` only does 3D-transform
  rotation (`rotateX/Y`, ~1037); there is no `Tm` rotation / vertical glyph
  advance for writing modes. The scaffold comment claiming a "90° text-matrix
  rotation" describes intent that was never implemented.

So text/inline-block in a vertical block is painted left-to-right at the wrong
axis. Confirmed on `text-indent-vlr-003` (single "A"): ours lands at
`(indent_x, top)`, ref at `(block_start, indent_y)` — the inline-axis offset is
applied to X instead of Y.

## Why there is no one-line increment

Even the "close" tests (`text-indent-vlr` 0.026, `text-align-vlr` 0.042 — small
because the content is a single Ahem glyph, so horizontal vs vertical glyph
*shape* is identical and only the inline-axis *offset* is wrong) need the inline
axis mapped to vertical. That requires the fragment/line model (or a paint-time
transpose) to know the block axis is horizontal — the same machinery the gross
multi-glyph tests need. There's no shortcut that moves the near-misses without
starting the model.

## Design: paint-time transpose (recommended over a model rewrite)

Keep `InlineLayout` producing a horizontal IFC in a **logical** coordinate space
(inline = x, block = line stacking), then apply ONE transpose when mapping
logical → physical for a vertical container. This localizes the change and reuses
all existing line-breaking / alignment / shaping.

Logical → physical for a vertical container of block-size `B` (physical width)
and inline content laid out to `(fx, lineY, fw, lineH)`:

| mode | physical x | physical y | glyph orientation |
|------|-----------|-----------|-------------------|
| `vertical-lr` / `sideways-lr` | `lineY` (block grows →) | `fx` (inline grows ↓) | 90° CW |
| `vertical-rl` / `sideways-rl` | `B − lineY − lineH` (block grows ←) | `fx` (inline grows ↓) | 90° CW |

`sideways-*` rotates glyphs 90° CW only; `vertical-*` additionally applies
`text-orientation` (default `mixed` — upright CJK, rotated latin; Ahem squares
are orientation-agnostic so the reftests don't exercise this, letting us ship
rotation-only first).

Where the transpose lands: two viable seams —
1. **Fragment rewrite** in `InlineLayout::layout` (after `applyTextAlign`,
   replacing `applyVerticalLineShift`): emit fragments carrying an explicit
   physical `(x, y)` + an `orientation` flag. Requires adding a physical-Y +
   orientation field to `InlineFragment` and teaching the painter to honour them.
2. **Painter transform**: wrap the IFC's glyph emission in a `Tm`/`cm` transpose
   when the container is vertical. Less model churn, but the painter must also
   transpose fragment rects for backgrounds / decorations / link annotations.

Seam (1) is cleaner for hit-testing (link rects, decorations already iterate
fragments) — recommend it.

## Increments (ordered by ROI / dependency)

1. **Model + single-glyph transpose** — ✅ SHIPPED 2026-07-06 (commits 8df312685
   + 39c0cdfcd): reworked `applyVerticalLineShift` into a real transpose (inline
   offset → `line.y`, column → `fragment.x`; `line-height:0` guarded to legacy),
   and routed `text-align` slack through the inline extent (the container's
   px-resolved `height`, since geometry height isn't committed during inline
   layout). css-writing-modes **412 → 420 (+8)**, 0 regressions, 2 unit tests.
   [Below is the original scoping for this increment.] — add physical `(x,y)` + `orientation` to
   `InlineFragment`; implement the table above for single-line content; paint
   glyphs at the physical position with the rotation matrix. Target: the ~28
   near-miss `text-indent-vlr` / `text-align-vlr` (single glyph). Verifies the
   transpose end-to-end with the least surface.
2. **Multi-glyph / multi-fragment vertical advance** — ATTEMPTED 2026-07-07,
   reverted (net +1 but not clean). Findings:
   - Single-fragment-multi-GLYPH already works: the painter rotates a fragment's
     glyph run 90°CW, so multiple glyphs in one fragment stack vertically. The
     gap is multi-FRAGMENT lines (text split by spaces/styling) and multi-LINE.
   - Extending the transpose to emit one LineBox per fragment (each at its
     inline-advance vertical position, sharing the column; `withColumnX` helper)
     is net **+1** (fixes writing-mode-vertical-{lr-002,rl-003}, regresses
     height-width-inline-non-replaced-vlr-003) — NOT clean.
   - The regression is WHITESPACE: a trailing Ahem space fragment (glyphs=1 —
     our Ahem-square renderer paints space as a filled square) stacks into the
     column as a stray square. But `skipWhitespace` then breaks
     writing-mode-vertical-rl-003 (which needs its whitespace fragment). The two
     want OPPOSITE treatment → needs real trailing-vs-interior whitespace
     collapse in the transposed column (or fix Ahem space to render blank),
     not a blanket skip.
   - `line-box-direction` (~36, the headline target) is ALSO multi-LINE +
     FLOATED: it needs (a) line-breaking measured against the INLINE extent
     (height), not the block-axis availableWidth — the same swap as increment
     1's text-align, but availableWidth is overloaded (the transpose uses it for
     the block extent, so thread BOTH extents), and (b) float support in the
     vertical container. Bigger than a transpose tweak.
3. **Text-align / text-indent along the vertical inline axis** — fold into (1);
   `applyTextAlign` already computes an inline offset — route it to the inline
   (now vertical) axis.
4. **Inline-block & block children inside vertical containers** —
   `block-flow-direction` (~48) mixes inline-block with `display:block` spans;
   depends on `stackChildrenListVertical` (exists) composing with the vertical
   IFC. Also unblocks the CB-vertical **abspos** cluster (see
   `css-writing-modes.md` — same mis-shaping).
5. **`text-orientation: mixed/upright`** — only if non-Ahem reftests need it;
   defer.

## Painter work

- A vertical text matrix: `Tm = [0 1 -1 0 tx ty]` (90° CW) per glyph run, with
  `tx/ty` at the transposed origin. Fake-bold/italic (mode 2 / skew) and
  decoration lines must compose with it.
- Fragment backgrounds, `text-decoration`, and `/Link` annotation rects
  (Painter iterates fragments for these) must use the transposed physical rect.

## Validation

- `wpt run --filter='css/css-writing-modes/**' --json` before/after (baseline
  412; stash-based, Ahem-loaded — never `--root=subdir`).
- Guard `css-writing-modes` horizontal tests (the scaffold currently passes
  some vrl atomic cases — don't regress `applyVerticalLineShift`'s wins).
- Oracle multi-glyph vertical text against Chromium (`scripts/oracle-render.sh`)
  — geometry, since the settler-off gate uses Ahem.
- Watch `css-sizing` orthogonal + `css-position` for spillover.

## References

- `InlineLayout.php`: `layout` (~74), `applyVerticalLineShift` (~368),
  `applyTextAlign` (~762), `resolveTextIndent` (~152).
- `InlineFragment.php` (add physical-Y + orientation), `LineBox.php`.
- `Painter.php`: glyph emission / `Tm` (grep `showText` / text matrix), fragment
  background + decoration + link-rect loops.
- `BlockLayout.php`: `stackChildrenListVertical` (~6780) for increment 4.
- `docs/plans/writing-mode-atomics.md` — the no-font atomic slice (composes with
  increment 4).
- `docs/plans/css-writing-modes.md` — the abspos cluster this unblocks.
- `project_writing_modes_state` memory — phases 1+3 done, this is Phase 4/B.
