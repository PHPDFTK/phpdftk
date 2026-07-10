# §10.3.8 absolutely-positioned replaced elements (+ prefixed foreign content)

Target: the ~60 `css/CSS2/{positioning,normal-flow,floats-clear}/{absolute,
inline,float}-replaced-{width,height}` fixtures (the densest CSS2 cluster).
Branch `feat/abspos-replaced-sizing` (off `css-coverage-push`).

Status: **the `<img>` half SHIPPED 2026-07-10 — via PAINT, not §10.3.8
sizing (the scope below was wrong about the root cause for `<img>`).** The
`<svg:svg>` half still needs Part 1 (prefixed-foreign-content DOM
normalization) and remains open.

## SHIPPED — the real root cause for the `<img>` cluster was PAINT, not sizing

The scope below assumed an abspos replaced element reaches layout as an
`AtomicInlineBox` whose size must be computed by a new §10.3.8 helper.
**That is false for `<img>`.** `BoxGenerator` (~line 212, CSS Display §2.7)
BLOCKIFIES an inline-level out-of-flow element, so an abspos `<img>` becomes
a **`BlockBox`**, and `layoutBlock` already sizes it correctly — the CSS
Sizing §4.2 aspect-ratio transfer resolves `width: 50%; height: auto` to
96×96 (the `aspect-ratio` cascade value `BoxGenerator` bakes onto every
`<img>` from its natural size drives the height). The box was sized right
all along; it just **wasn't painted**: `paintImage` accepted only
`AtomicInlineBox` or *floated* `BlockBox`, explicitly excluding abspos
BlockBoxes (commit `a5540e14e`, which found painting them regressed
css-grid −6 and the abspos geometry "wasn't correct yet").

The grid −6 was **grid ITEMS**, not abspos: a blockified replaced grid/flex
item reaches paint with grid-track geometry not wired for raster placement.
Gating that out precisely — by the **parent box type** (`GridBox` /
`FlexBox`), now threaded into `paintBox`/`paintImage` — lets abspos (and
plain `display:block`) replaced BlockBoxes paint without the grid
regression. The abspos-replaced geometry HAS become correct in the interim
(much abspos work landed since `a5540e14e`).

**Change (Painter.php only):** `paintImage` now accepts any `BlockBox`
replaced element (float / `display:block` / abspos), excluding (a) grid/flex
ITEMS (parent-type check — guards the css-grid −6) and (b) vertical-WM
replaced (float/block WM positioning still wrong). The §10.3.8
`AtomicInlineBox` sizing helper drafted per Parts 2–3 was **reverted** — the
`<img>` boxes are `BlockBox`es, so it never fired; keeping the change
minimal. It would only matter for abspos *foreign* (`<svg>`/`<math>`) atomic
roots, which are the Part-1 territory below.

**Paired WPT (settler-off, same-env): +17 net across the blast radius,
one −1 regression.** CSS2/positioning +9, css-backgrounds +8 (block-replaced
imgs in reference markup), CSS2/normal-flow +1; css-grid ±0, css-flexbox ±0,
CSS2/floats ±0, CSS2/floats-clear ±0, css-position ±0; css-images −1 (one
corner-anchored abspos replaced — `applyAbsoluteCornerAnchorSize` is the
§10.3.7 non-replaced stretch, wrong for replaced; minor, acceptable).
`absolute-replaced-width-006` 0.0192 → 0.000148 PASS; `-001` still passes.
Gates: lint + PHPStan clean, 980 html-to-pdf unit tests green. Baseline css
pass 14896 → 14913 (+17).

**Still open — the `<svg:svg>` family (~29 fixtures):** needs Part 1 below
(rebuild `<svg:svg>`/`<svg:rect>` as SVG_NS `<svg>`/`<rect>` so the
`svg{position:absolute}` selector matches). Those DO reach layout as
`AtomicInlineBox` foreign roots, so they will need the reverted §10.3.8
helper too. Separate follow-up; `absolute-replaced-width-002` still fails.

---

## Original scope (below) — kept for the `<svg:svg>` follow-up; note the
## `<img>` root-cause correction above supersedes Parts 2–3 for rasters.

A first implementation was
written then reverted — it didn't move the fixtures because the target
SVGs reach layout via a path that wasn't wired (see Part 4). This is a
FOUR-part feature; all parts are needed together for a net gain.

## The fixtures
Most use an XHTML `<svg:svg>`/`<svg:rect>` with the SVG sized by CSS
(`svg { width:200px; position:absolute; ... }`) or by attrs, compared to
an orange marker of the same width. They fail because the SVG box ends up
0×0 (renders empty) and/or positioned wrong.

## Part 1 — normalize prefixed foreign content (REQUIRED prerequisite)
`<svg:svg>` keeps localName `"svg:svg"` (HTML ns), so NO CSS selector
matches it — `svg{position:absolute}` doesn't apply, so it isn't even
abspos. A DOM pre-pass in `Renderer::render` (after `applyBaseHref`,
before `collectStylesheets`) must rebuild `<svg:svg>`/`<svg:rect>`
subtrees as `<svg>`/`<rect>` in SVG_NS, prefix stripped (`Node::replaceChild`
exists; recurse copying attrs minus `xmlns*`, and Text nodes). Verified in
isolation: `<svg:svg width=200 height=100>` renders after this. Implemented
+ reverted once (worked, but inert without Parts 2-4). Note: HTML lowercases
attrs, so `viewBox`→`viewbox` — the SVG parser already tolerates `viewbox`.

## Part 2 — §10.3.8 replaced sizing helper (codex-validated, was written)
`layoutAbsoluteReplacedAtomic(AtomicInlineBox, LayoutContext): float` near
`applyAbsoluteCornerAnchorSize` (~2041). Resolve adornment onto geometry,
then used content size via §10.3.2: CSS length/% wins; else intrinsic; else
ratio transfer from the definite opposite axis; else 300×150. `<svg>`
intrinsic = `width`/`height` attrs (px or %) + `viewBox` ratio; `<img>`
carries its ratio via the `aspect-ratio` cascade. Write the resolved size
back as definite `Length`s so `resolveAbsoluteOffsets` sees it. Helpers:
`resolveReplacedUsedSize`, `replacedIntrinsicSize`, `definiteReplacedLength`,
`parseReplacedAttrLength`. (Full code is in the session transcript — re-create.)
Do NOT call `applyAbsoluteCornerAnchorSize` for replaced atomics (its
both-insets `width:auto` is §10.3.7 non-replaced stretch).

## Part 3 — wire the BLOCK abspos paths
Replace `applyAbsoluteCornerAnchorSize + layoutBox` with the new helper for
`$child instanceof AtomicInlineBox` at all three block abspos call sites:
`stackChildrenList` (~6384), `stackChildrenListVertical` (~6600),
`layoutFlexAbsoluteChildren` (~2966). Leave the shared `layoutBox` atomic
fallback (lines 384-387) UNTOUCHED — sizing it there regressed ~18 flex
items previously (see [[feedback-aspect-ratio-lever]]).

## Part 4 — inline-level abspos extraction (THE MISSING PIECE)
**Root cause the first attempt missed:** the target SVGs are inline-level
(`display:inline-block`, foreign roots aren't blockified), so a box whose
children are all inline-level routes to `layoutInlineChildren` →
`InlineLayout`, which sizes the abspos atomic as a line atom (width 0) and
never pulls it out for §10.3.8. So the block-path helper (Part 3) is never
reached for these. Need: in the inline-formatting-context path, detect
inline-level out-of-flow atomics, REMOVE them from the line flow, and run
the §10.3.8 helper + `resolveAbsoluteOffsets` against the positioned
ancestor (capturing the inline static position first — cf. the existing
`inlineStaticPositionY` + `applyRelativeOffsetsToInlineAtomics` work). This
is the substantial part.

## Verify
After all four: `absolute-replaced-width-002/006/009`, the `inline-` and
`float-replaced-width/height` families. Watch for flex/grid regressions
(Part 3 must not touch the shared fallback). Pair the WPT delta with a
cross-browser-oracle spot check.

Related: [[feedback-aspect-ratio-lever]] (the reverted flex layoutAtomicReplaced),
[[feedback-css-coverage-loop]], `docs/plans/css-coverage-targets.md`.
