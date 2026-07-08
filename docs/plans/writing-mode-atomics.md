# Writing-mode & logical properties for atomic inline boxes

Give the no-font atomic layout path (`layoutAtomicOnly`) — and the shaped path
(`walkInline` atomic case) — real logical-property and writing-mode support, so
`inline-size` / `block-size` / `padding-inline-*` / `padding-block-*` on
inline-block / replaced boxes resolve correctly under `vertical-lr/rl` and
`sideways-lr/rl`.

## Why

The atomic inline layout reads **physical** box-model properties only
(`width`, `height`, `padding-left`, …). It has no mapping for logical properties
or writing modes. That produces wrong geometry for any atomic sized with logical
props or laid out in a vertical/sideways mode.

Surfaced by the html `568 → 564` regression (bisected to `9f11ccb4`, the atomic
line-wrapping change). The 4 regressed tests are all the same 10-textarea grid:

```
textarea { font: 10px/1 Ahem; inline-size: 0; block-size: 10em;
           padding-inline-start: 8em; overflow: hidden }
<textarea>X</textarea> <textarea class="rtl">X</textarea> <br>
<textarea class="vlr">…  class="vrl"… class="slr"… class="srl"… (+ rtl variants)
```

`html/rendering/replaced-elements/the-textarea-element/textarea-padding-{istart,
bstart}-moves-content-001.tentative`, `…-{iend,bend}-overlaps-content-001`.

Each textarea is a **padding-only box** (`inline-size:0` + `padding-inline-start:
8em` → 80px inline extent from padding alone), across 8 writing modes.

### Important framing: these were false passes

We never rendered the writing-mode textareas correctly — they matched the
*blank* reference **by accident** until `9f11ccb4`'s line-box / wrap change
shifted the mis-sized boxes and broke the coincidence. So the html −4 is
**false-pass unmasking, not a capability regression**, and the refreshed
baseline (html 564) is honest. `9f11ccb4` is net-positive (CSS2 +10, flexbox +9,
tables +2) and must NOT be reverted. Recovering these tests means building the
feature — or gaming the blank match, which we won't do.

## Root cause

`packages/html-to-pdf/src/Layout/InlineLayout.php`, `layoutAtomicOnly()`
(~line 422):

- Reads `get('width')` — logical `inline-size` isn't mapped, and in vertical
  modes the inline axis is the *block* physical axis anyway.
- `if ($width <= 0.0) { continue; }` (~line 449) **skips padding-only boxes**:
  a `width:0` box with `padding-inline-start:8em` has a non-zero border/padding
  box but is dropped entirely (horizontal textareas vanish).
- Vertical textareas fall through to physical width and mis-size (observed
  `w=100` where the mode should map `block-size:10em` to the physical axis).

The same `AtomicInlineBox` case in `walkInline` (~line 1255, the shaped path)
has the identical physical-only assumption.

## Scope

1. **Logical → physical mapping** keyed on the box's resolved `writing-mode`
   (+ `direction`): `inline-size`/`block-size` → `width`/`height`;
   `padding-inline-{start,end}` / `padding-block-{start,end}` (and margins /
   borders) → physical sides. There is prior writing-mode plumbing in the block
   path (`WritingMode::fromStyle`, the vertical axis-swap in `layoutBlock` /
   `stackChildrenListVertical`) to reuse.
2. **Don't skip padding-only boxes.** Replace `if ($width <= 0.0) continue` with
   a check on the *outer* (padding+border) box, so a zero-content box with
   padding still lays out and paints its box.
3. **Atomic sizing under vertical modes** — the atomic's inline extent runs
   along the physical block axis; advance/line-box tracking (added by
   `9f11ccb4`) must advance along the correct physical axis.
4. Apply symmetrically in `walkInline`'s atomic case for the shaped (font-loaded)
   path.

## Impact & ROI

- Directly: the 4 `.tentative` textarea-padding tests (html 564 → 568).
- Broader: any inline-block / replaced content sized with logical properties or
  under vertical writing modes.
- **ROI is low as a standalone task** — 4 `.tentative` niche tests for a
  writing-mode feature. Best done as part of a broader writing-mode-compliance
  pass (`css-writing-modes` is a large bucket), not for these 4 alone. The
  baseline is already honest at 564; there is no regression pressure to fix this
  urgently.

## Validation

- Oracle the textarea grid against Chromium (`scripts/oracle-render.sh`) — note
  the reference renders text (default font) that our settler-off gate lacks, so
  compare **box geometry**, not glyphs.
- `wpt run --filter='html/rendering/**' --json` before/after (stash-based).
- `wpt run --filter='css/css-writing-modes/**' --json` to catch spillover both
  ways.

## References

- `packages/html-to-pdf/src/Layout/InlineLayout.php` — `layoutAtomicOnly`
  (~422, the `width<=0` skip at ~449, box-model insets at ~465), `walkInline`
  atomic case (~1255).
- `9f11ccb4335dbf1b7078f0db25f12443ed52135d` — the wrap commit that unmasked it.
- `reference_wpt_gate` memory — the bisect + false-pass assessment.
- Block-path writing-mode prior art: `WritingMode::fromStyle`,
  `stackChildrenListVertical` in `BlockLayout.php`.
