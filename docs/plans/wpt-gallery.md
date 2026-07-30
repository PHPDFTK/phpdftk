# WPT compliance gallery on the docs site

Goal: publish the WPT corpus alongside our rendered output so anyone can
browse "here's the test, here's what phpdftk produces, here's the
reference" and judge compliance visually — not just read a pass-rate
number. Requested 2026-07-29.

## Why it's cheap to build

Every piece already exists; the gallery is the UI layer over them:

- **Render + rasterise** — `HarnessRunner` renders each WPT test through
  the real pipeline to PDF, `Rasteriser` (Ghostscript, 96dpi) turns it
  into a PNG. This is exactly what the pass-rate harness already does per
  test.
- **Expected side** — two independent oracles are available:
  1. the WPT **reference file** (`<link rel="match">` / `-ref.*` sibling),
     rendered through our own pipeline (self-consistency); and
  2. the **cross-browser oracle** (`wpt cross-browser`) — Blink / Gecko /
     WebKit print-to-PDF, the absolute-correctness signal.
- **Score** — `Scorer` (ImageMagick `compare -metric AE`) already yields
  the per-pair pixel AE; `matrix.php` already emits per-engine pass data.

So the gallery is: run the existing pipeline, KEEP the PNGs instead of
deleting them, emit a manifest, and render a grid.

## Data model

One generator (`scripts/build-wpt-gallery.php`) walks a `--filter` slice
and, per test, emits:

```json
{
  "testId": "css/css-flexbox/flex-minimum-height-flex-items-011",
  "source": "css/css-flexbox/flex-minimum-height-flex-items-011.xht",
  "ours": "img/css-flexbox/flex-minimum-height-flex-items-011.ours.png",
  "reference": "img/.../-011.ref.png",
  "engines": { "chromium": "…png", "firefox": "…png", "webkit": "…png" },
  "verdict": "fail",
  "ae": { "reference": 0.021, "chromium": 0.019, "firefox": 0.019, "webkit": 0.024 },
  "flags": ["ahem"]
}
```

`img/*` are the kept PNG thumbnails (downscaled ~300px for the grid, full
on the detail page). `source` links to the raw test HTML.

## Generation

- `scripts/build-wpt-gallery.php --filter='css/css-flexbox/**' --out=docs/generated/wpt-gallery`
  reuses `HarnessRunner` with a new opt-in **artifact directory**: when
  set, it copies the test + reference PNGs (named by test id) into the
  dir and records their paths on `TestResult` instead of unlinking. No
  new render/score/locate-reference code — just don't throw the artifacts
  away.
- Engine columns are populated only when `--engines=` is passed (the
  cross-browser oracle is slow; default is ours-vs-WPT-reference only).
- Emits `manifest.json` (array of the records above) per generated slice.

## Frontend (Astro Starlight)

- A gallery page under `standards/` reads `manifest.json` at build time
  and renders a **filterable grid**: each cell = test name + our-render
  thumbnail + a pass/fail badge; hover flips to the reference.
- Client-side filters: by cluster (path prefix), by verdict (pass/fail),
  by AE band, by flag (ahem / image / script).
- Click → **detail page**: side-by-side ours | reference (| each engine),
  the AE numbers, and the test source inline. This is the "compare"
  surface the request is really about.

## Scale + hosting

The full corpus is ~22k tests; PNGs for all of them are GBs — too heavy to
commit into the docs repo. Reuse the established generated-artifact
pattern (benchmarks / compliance already do this):

- CI generates the gallery into `docs/generated/wpt-gallery/` and publishes
  it to an orphan branch (`_wpt-gallery`), which the Starlight build pulls
  in — same mechanism as `_benchmarks` / `_compliance`.
- v1: ship a **curated / filtered** slice (the failing + near-miss tests,
  which are the interesting comparisons) rather than all 22k. The
  generator is filter-scoped, so scope is a CLI flag.
- Thumbnails downscaled; full renders lazy-loaded on the detail page.
- WPT test HTML is open-source (W3C test suite license), so republishing
  the source alongside is fine; link to the upstream test where possible
  to avoid duplicating the whole corpus.

## Phases

1. **Generator + manifest** (the reusable data layer): artifact-dir opt-in
   on `HarnessRunner`, `build-wpt-gallery.php`, JSON schema. Run on one
   cluster, eyeball the JSON + PNGs.
2. **Static gallery page**: Astro page consuming the manifest, grid +
   thumbnails + verdict badges. No filters yet.
3. **Filters + detail page**: client-side filtering; side-by-side detail
   with test source and per-engine columns.
4. **CI + orphan branch**: generate in CI, publish to `_wpt-gallery`,
   embed. Decide curated-slice vs full-corpus hosting.

## Open decisions

- Curated failing-tests slice vs full 22k corpus (hosting cost).
- Expected side: WPT reference only, or also the 3-engine oracle columns
  (needs the browser sweep in CI + the WebKit build).
- Whether to show the pixel **diff heatmap** (ImageMagick can emit one)
  per test, not just the two images.
