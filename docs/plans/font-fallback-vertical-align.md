# Text-rendering foundation + mixed-size vertical-align (the css text-bucket lever)

Investigation 2026-07-14, branch `css-90-push`. Post-clean-lever-era census
drill into css text buckets. **No code shipped** — the foundation piece is
net-negative *standalone* and the win it unlocks is a core-model refactor that
must land WITH it. Full working patch for the foundation is committed alongside
this doc at `docs/plans/artifacts/font-fallback-baselineshift.patch` (applies on
`css-90-push`); the design below is turnkey for the combined push.

## The finding that reframes the whole text grind

**The WPT harness wires NO default font** (`HarnessRunner` builds
`RendererOptions` with no `withDefaultFont`, no `fontMap`), in *both* local and
CI. Consequence: `InlineLayout::layout()` resolves the IFC-root box's font,
and when that is null it aborts the whole inline pass to `layoutAtomicOnly` —
**every text run renders blank**, even runs that use a loaded `@font-face`
(Ahem) via a descendant `<span>`. Root box font is null whenever the block's
own `font-family` doesn't resolve (generic `serif`/`sans-serif`, or an
`@font-face` only used deeper in the tree).

Why the corpus still shows ~14,900 css passes despite blank text: reftests
compare *our* test render vs *our* ref render. When text isn't the
differentiator, BOTH sides render blank → they match → pass. Tests FAIL only
when text presence/position is the differentiator (e.g. `baseline-shift`, where
the ref uses positioned `<div>`/`<img>` that DO render while the test uses Ahem
text that does NOT).

**Implication: every Ahem/@font-face text test is currently unverifiable
locally** — you cannot see whether a text-layout fix worked because the text
is blank. This blocks local work on the biggest remaining css clusters:
css-writing-modes (637), css-inline (109+), css-text (145), and much of CSS2
linebox/normal-flow. Verifying those requires the font foundation below.

## Piece 1 — the `@font-face` fallback (the foundation) — VALIDATED, net −3

`FontResolver::anyAvailableFont(): ?FontFaceData` returns the first loaded face
(faceMap then fontMap). In `layout()`, when the root font is null, shape the
IFC in that fallback so `walkInline` can proceed and re-resolve each descendant
to its own family. Guarded by `fallbackFontActive`: while active, the TextBox
branch of `walkInline` emits glyphs **only** for runs whose own `font-family`
actually resolves (`resolveBoxFont($box, null)['font'] !== null`) — runs in an
unloaded family (generic `serif`, unmatched web font) stay blank, exactly as
before. This gate is essential.

Paired settler-off WPT (before/after, same env):

| variant | css-text | css-fonts | css-inline | css-backgrounds | css-values | net |
|---|---|---|---|---|---|---|
| **naive** (shape all runs in fallback) | −171 | −17 | −2 | −3 | −8 | **−201** |
| **conservative** (gate on real family match) | **0** | **−3** | 0 | 0 | 0 | **−3** |

The conservative gate recovers ~99%. The residual −3 (css-fonts) are
`size-adjust-01`, `size-adjust-unicode-range-system-fallback`,
`font-variant-emoji-005` — **false-passes being correctly unmasked**: we don't
implement `size-adjust` / `unicode-range` face selection / emoji, so those
tests SHOULD fail; they only "passed" because blank text hid the mismatch.
No NEW passes anywhere — the foundation produces **0 wins standalone**.

**Do NOT ship the naive version (−201).** Do NOT ship the foundation alone
(net −3, no offsetting gain — fails the completeness gate). It is only worth it
paired with Piece 2.

## Piece 2 — mixed-size inline vertical-align (the actual win, ~409 fixtures)

`vertical-align: top | middle | bottom | text-top | text-bottom` and
`baseline-shift: top | center | bottom` are unimplemented (return 0 in
`resolveVerticalAlign`/`resolveBaselineShift`). **409 corpus fixtures** use
`vertical-align: middle/top/bottom` (~323 reftests); many are Ahem text tests
that need BOTH the font foundation and this. (Note: table-cell
`vertical-align` is a SEPARATE mechanism — this is the inline-level subset.)

### The blocker: the current line model can't express it

`lineHeightFor` = `max(parentLineHeight, maxFontSize × multiplier)`. Fragments
store only a scalar `baselineShift`. The **painter** positions each fragment at
`baselineY = box.y + line.y + (fragment's own ascent) + baselineShift`
(`Painter.php:3125`) — i.e. each fragment sits its *own* ascent below the line
top. For mixed sizes this isn't even baseline-aligned; it's ~top-of-em-box
aligned. `top`/`middle`/`bottom` cannot be expressed as a fixed per-fragment
`baselineShift` until the line-box extent is known (they're line-box-relative,
and the extent depends on the baseline-aligned fragments — inherently two-pass,
CSS2 §10.8 / CSS-Inline-3 §5).

### Required refactor (both layers)

1. **Single line baseline.** Compute one baseline per line = max ascent over
   baseline-participating fragments. Track per-fragment ascent/descent (text:
   from font metrics × size; atomic: box height + its own baseline).
2. **Two-pass extent.** Pass 1: place baseline/sub/super/length fragments,
   accumulate line over/under edges. Pass 2: place `top` (fragment top → line
   over edge), `bottom` (fragment bottom → line under edge), `middle` (center →
   baseline − x-height/2). Then recompute extent if top/bottom grew it (spec
   iterates; one extra pass suffices for the common cases).
3. **Painter change.** Position fragments against the single line baseline, not
   each fragment's own ascent — so `Painter.php:3125` becomes
   `line.y + line.baseline + shift`. This touches ALL text rendering, so
   re-run the full css/html/svg/mathml WPT gate to catch regressions.
4. `baseline-shift: top/center/bottom` maps onto the same extent math.

### Baseline-shift `<length-percentage>` (small, already designed)

Register `baseline-shift` (initial `0`, non-inherited). In `resolveBaselineShift`
(the renamed `resolveVerticalAlign`, now reading both longhands): `sub`/`super`
as today; `Length` → `-value` (positive raises); `Percentage` →
`-(pct/100) × resolveLineHeight(box, fontSize)` (§4.2 % of line-height). Apply
to InlineBox children AND to the atomic token (an `<img baseline-shift>` needs
its OWN shift, not just inherited). Verified math against
`baseline-shift-length-percentage-ref`: `1em`→raise 20px, `-100%`→lower 40px
(=2×line-height), `-0.2em`→lower img 4px. With text rendering ON this fixture
moved 0.010→0.015 (text now visible but our inline layout not yet ref-accurate)
— it needs Piece 2's correct baseline to actually pass.

## EMPIRICAL UPDATE (2026-07-15) — the lever is ALL-OR-NOTHING, not incremental

Built Piece 1 (font foundation) + a first increment of Piece 2 (text-only
`vertical-align: top/bottom` + `baseline-shift: top/center/bottom`, via a
post-pass `applyLineBoxAlignment` that rewrites `baselineShift` once line height
is known — patch at `docs/plans/artifacts/vertical-align-increment1.patch`).
The mechanism **works** — verified in the painter that keyword-aligned glyphs
move to the correct line-relative Y (a 20px `X` with `baseline-shift:bottom`
paints at baselineY 116 instead of 16). But paired settler-off WPT:

| bucket | before | after | delta |
|---|---|---|---|
| CSS2/linebox | 157 | 156 | **−1** |
| css-inline | 48 | 48 | 0 |
| css-align | 28 | 28 | 0 |

**Zero tests flipped; one regressed.** Three compounding correctness
requirements — all must hold before any fixture crosses the 0.01 threshold:

1. **Line height is wrong.** `lineHeightFor` uses the *block's* line-height
   multiplier (1.2) × max fragment font-size, not each inline box's own
   `line-height`. `font-size:100px; line-height:1` yields line height **120,
   not 100** — every top/bottom offset is off by the leading. Separate bug,
   fix first.
2. **Atomics (img / inline-block) unhandled.** The baseline-shift top/center/
   bottom fixtures each contain an `<img>`; with it at baseline the horizontal
   flow shifts, so correctly-aligned text no longer overlaps the ref and the AE
   is unchanged. `vertical-align-applies-to-012` (inline-block) regressed −1 from
   an atomic edge-case. Atomic alignment needs the box's computed margin-box
   height, not available at token time.
3. **No half-leading / single baseline.** The painter positions each fragment at
   `line.y + ownAscent`; mixed-size runs aren't baseline-aligned and there's no
   half-leading. `middle`/`baseline` for mixed sizes need a real line baseline.

**Conclusion:** the 409-fixture lever cannot be landed incrementally — a fixture
passes only when line-height, single baseline, atomic vertical sizing, AND
half-leading are simultaneously exact. That is a **complete, precise line-box
rewrite** (InlineLayout line assembly + painter vertical placement), multi-
session and high-risk, with **no bankable WPT gain until fully correct**. Cost
is far higher than the fixture count implied. Revisit only as a dedicated
rewrite. The increment patch is preserved as the scaffold (the post-pass
architecture is sound; the model beneath it must be made correct).

## Sequencing for a net-positive changeset

Land Piece 1 (foundation) + Piece 2 (vertical-align two-pass + baseline-shift)
TOGETHER on `css-90-push`. Measure the FULL css bucket plus html/svg/mathml
(Piece 2's painter change is global). Ship only if net-positive after
absorbing the −3 unmasked false-passes. Heavy unit coverage (3:1 neg:pos):
`FontResolver::anyAvailableFont` (empty maps → null; faceMap precedence;
fontMap fallback), the `fallbackFontActive` gate (resolvable family renders;
generic `serif` stays blank; no @font-face → still atomic-only),
`resolveBaselineShift` (length/percentage/sub/super/keyword math), and the
two-pass extent for top/middle/bottom with mixed font sizes.

Related: [[reference_wpt_blocked_clusters]] (no-default-font → text h=0 was
noted but not root-caused to the abort-to-atomic path until now),
[[feedback_transparent_relative_levers]] (false-pass unmasking precedent — but
that had +18 real gains to absorb the 7 unmaskings; this foundation has 0),
[[feedback_layout_wpt_verify]], `docs/plans/css-90-census.md`.
