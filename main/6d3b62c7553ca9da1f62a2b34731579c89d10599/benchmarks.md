# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-04 00:35:29 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.136ms | 2.531ms | 2.730ms | 4.722ms | 7.016ms |
| FPDF | 796.543μs | 845.315μs | 915.089μs | 1.525ms | 2.272ms |
| TCPDF | 9.883ms | 10.829ms | 11.925ms | 20.521ms | 31.235ms |
| mPDF | 24.884ms | 28.922ms | 32.902ms | 65.153ms | 105.152ms |
| Dompdf | 11.230ms | 15.847ms | 21.361ms | 72.731ms | 162.511ms |

## Peak Memory — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 9.218mb | 5.947mb | 6.033mb | 6.667mb | 7.490mb |
| FPDF | 5.072mb | 5.072mb | 5.072mb | 5.072mb | 5.084mb |
| TCPDF | 12.912mb | 12.912mb | 12.912mb | 12.912mb | 12.912mb |
| mPDF | 17.624mb | 17.683mb | 17.721mb | 18.014mb | 18.376mb |
| Dompdf | 9.357mb | 9.577mb | 9.898mb | 12.591mb | 15.954mb |

## Generation Time — `MemoryBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 3.333ms | 3.658ms | 3.827ms | 5.826ms | 8.373ms |
| FPDF | 1.047ms | 1.151ms | 1.217ms | 1.893ms | 2.759ms |
| TCPDF | 14.396ms | 15.359ms | 16.519ms | 26.388ms | 38.441ms |

## Peak Memory — `MemoryBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 5.373mb | 5.420mb | 5.479mb | 5.972mb | 6.570mb |
| FPDF | 4.455mb | 4.455mb | 4.455mb | 4.455mb | 4.505mb |
| TCPDF | 12.487mb | 12.487mb | 12.487mb | 12.487mb | 12.488mb |

## Writer Levels Comparison — `WriterLevelsBench`

Same workload (N pages with heading + body text) rendered through each
writer level, so the abstraction overhead is visible directly. Lower is
better; the higher-level APIs (`Pdf` → `PdfDoc` → `PdfWriter`) trade
some performance for ergonomics.

### Generation Time

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| Pdf (Level 3) | 3.343ms | 4.456ms | 12.607ms |
| PdfDoc (Level 2) | 2.691ms | 3.129ms | 7.517ms |
| PdfWriter (Level 1) | 2.299ms | 2.785ms | 6.960ms |

### Peak Memory

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| Pdf (Level 3) | 6.057mb | 6.220mb | 7.897mb |
| PdfDoc (Level 2) | 5.714mb | 5.872mb | 7.441mb |
| PdfWriter (Level 1) | 5.389mb | 5.548mb | 7.123mb |

## Tables — `TablesBench`

Table rendering through `Pdf::addTable()` (Level 3, flow-paginated)
and `Writer\Page::drawTable()` (Level 2, positioned). Both share the
same underlying `TableRenderer`; the delta isolates the cost of the
flow-layout engine.

### Generation Time

| Library | 10 rows | 100 rows | 500 rows |
|---|---|---|---|
| Pdf (Level 3) | 4.326ms | 12.139ms | 46.970ms |
| PdfDoc (Level 2) | 3.747ms | 9.925ms | — |

### Peak Memory

| Library | 10 rows | 100 rows | 500 rows |
|---|---|---|---|
| Pdf (Level 3) | 6.408mb | 9.203mb | 21.611mb |
| PdfDoc (Level 2) | 6.214mb | 9.029mb | — |

## Lists — `ListsBench`

Bullet-list rendering through `Pdf::addList()` (Level 3) and
`Writer\Page::drawList()` (Level 2). Both share `ListRenderer`.

### Generation Time

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 4.059ms | 11.714ms | 45.476ms |
| PdfDoc (Level 2) | 3.249ms | 7.295ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.040mb | 6.592mb | 9.036mb |
| PdfDoc (Level 2) | 5.829mb | 6.323mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.187ms | 1.657ms | 5.940ms |
| smalot/pdfparser | 1.977ms | 2.359ms | 5.720ms |
| setasign/fpdi | 1.903ms | 2.811ms | 29.872ms |

## Peak Memory — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 5.341mb | 4.243mb | 4.595mb |
| smalot/pdfparser | 4.800mb | 4.884mb | 6.601mb |
| setasign/fpdi | 4.743mb | 4.769mb | 5.526mb |

## Compatibility — `ReadPdfBench`

Parse time for PDFs using spec-compliant features. `FAIL` = parser threw an exception.

| Library | Spec-compliant xref (20-byte SP CR LF) | Cross-reference stream (PDF 1.5) |
|---|---|---|
| phpdftk | 2.017ms | 1.364ms |
| smalot/pdfparser | FAIL | 1.891ms |
| setasign/fpdi | 2.988ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.373mb  | 3.333ms   | ±1.34%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.420mb  | 3.658ms   | ±3.19%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.479mb  | 3.827ms   | ±0.20%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.972mb  | 5.826ms   | ±0.24%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.570mb  | 8.373ms   | ±1.28%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 14.396ms  | ±1.03%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 15.359ms  | ±0.35%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 16.519ms  | ±0.78%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 26.388ms  | ±1.99%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 38.441ms  | ±0.33%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.047ms   | ±1.87%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.151ms   | ±15.20% |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.217ms   | ±0.19%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.893ms   | ±0.29%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.759ms   | ±0.58%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.389mb  | 2.299ms   | ±0.70%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.548mb  | 2.785ms   | ±0.71%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.123mb  | 6.960ms   | ±0.55%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.714mb  | 2.691ms   | ±0.74%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.872mb  | 3.129ms   | ±0.52%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.441mb  | 7.517ms   | ±0.37%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.057mb  | 3.343ms   | ±1.17%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.220mb  | 4.456ms   | ±0.57%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.897mb  | 12.607ms  | ±0.43%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.496mb | 85.903ms  | ±0.84%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.388mb | 375.573ms | ±0.38%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 45.451mb | 1.463s    | ±0.22%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.562mb | 261.145ms | ±0.26%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 32.459mb | 199.862ms | ±0.79%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.305mb | 161.909ms | ±0.28%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.376mb | 221.450ms | ±0.55%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.913mb | 182.709ms | ±0.19%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.468mb | 348.564ms | ±1.00%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 16.008mb | 52.616ms  | ±0.30%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.924mb | 46.436ms  | ±0.44%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.850mb | 42.629ms  | ±0.86%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.193mb | 143.036ms | ±1.47%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.913mb | 47.832ms  | ±0.24%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 16.131mb | 60.865ms  | ±0.20%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.559mb | 90.118ms  | ±0.52%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.817mb | 38.178ms  | ±0.32%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.754mb | 46.619ms  | ±0.14%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.782mb | 48.513ms  | ±0.65%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.750mb | 47.149ms  | ±0.57%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.838mb | 45.996ms  | ±0.77%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.691mb | 71.545ms  | ±0.56%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.765mb | 44.347ms  | ±0.35%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.418mb | 39.221ms  | ±0.40%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.719mb | 43.289ms  | ±0.39%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.740mb | 48.192ms  | ±0.66%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.733mb | 48.462ms  | ±1.21%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.933mb | 42.590ms  | ±0.85%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 19.169mb | 230.993ms | ±0.54%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.388mb | 171.307ms | ±1.23%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.195mb | 56.772ms  | ±1.30%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.802mb | 116.299ms | ±0.68%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.870mb | 1.414s    | ±0.25%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.257mb | 25.887ms  | ±1.77%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.283mb | 58.999ms  | ±1.15%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.094mb | 522.206ms | ±1.47%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.541mb | 63.876ms  | ±8.79%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.260mb | 86.230ms  | ±1.06%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 33.029mb | 726.978ms | ±0.78%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.305mb | 18.673ms  | ±0.57%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.305mb | 42.815ms  | ±0.54%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.948mb | 317.200ms | ±0.80%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.224ms   | ±0.71%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.657ms   | ±1.06%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.940ms   | ±0.53%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.017ms   | ±1.38%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.364ms   | ±1.17%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.977ms   | ±1.04%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.359ms   | ±0.53%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.720ms   | ±0.48%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 547.939μs | ±2.27%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.891ms   | ±0.50%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.903ms   | ±1.12%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.811ms   | ±0.48%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.872ms  | ±0.51%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.988ms   | ±1.03%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.522ms   | ±0.80%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.960mb  | 7.231ms   | ±0.69%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.932mb  | 5.445ms   | ±9.76%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.976mb  | 3.822ms   | ±1.21%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.524μs   | ±19.62% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.187ms   | ±0.66%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.503mb  | 26.788ms  | ±1.27%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.671mb | 239.793ms | ±0.11%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.999mb | 1.194s    | ±0.32%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.040mb  | 4.059ms   | ±0.76%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.592mb  | 11.714ms  | ±8.56%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.036mb  | 45.476ms  | ±0.73%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.829mb  | 3.249ms   | ±0.34%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.323mb  | 7.295ms   | ±0.57%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.886mb  | 2.287ms   | ±0.58%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.947mb  | 2.531ms   | ±0.57%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.033mb  | 2.730ms   | ±0.60%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.667mb  | 4.722ms   | ±0.49%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.490mb  | 7.016ms   | ±0.42%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.350mb  | 3.523ms   | ±0.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.342mb  | 3.780ms   | ±0.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.779mb  | 12.288ms  | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.394mb  | 3.608ms   | ±0.53%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.675mb  | 2.390ms   | ±0.78%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 642.087μs | ±13.77% |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.104mb  | 3.164ms   | ±0.73%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.198mb  | 3.643ms   | ±1.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.119mb  | 3.200ms   | ±0.52%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.175mb  | 198.828ms | ±22.34% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.236mb  | 3.588ms   | ±0.98%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.851mb  | 5.808ms   | ±22.06% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.983mb  | 6.037ms   | ±0.69%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.883ms   | ±0.68%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.829ms  | ±0.91%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.925ms  | ±0.81%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.521ms  | ±0.34%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.235ms  | ±0.61%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 796.543μs | ±1.24%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 845.315μs | ±2.64%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 915.089μs | ±1.65%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.525ms   | ±0.32%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.272ms   | ±0.60%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 24.884ms  | ±1.65%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.922ms  | ±0.92%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.902ms  | ±0.34%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.153ms  | ±0.71%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 105.152ms | ±0.34%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.230ms  | ±0.55%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.847ms  | ±0.69%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.361ms  | ±0.56%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 72.731ms  | ±0.72%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 162.511ms | ±0.67%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.049mb  | 5.005ms   | ±0.95%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.496mb  | 49.842ms  | ±0.61%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.665μs   | ±17.39% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.666μs   | ±12.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.334μs   | ±9.52%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 223.740ms | ±18.31% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 462.787μs | ±0.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.463mb  | 2.983ms   | ±0.39%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.060mb  | 3.360ms   | ±0.80%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 13.312ms  | ±7.29%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 86.540ms  | ±0.38%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.570ms  | ±0.95%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 24.935ms  | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.896mb  | 160.619ms | ±35.87% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.288mb  | 13.252ms  | ±0.52%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.261mb  | 13.197ms  | ±0.53%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.269mb  | 13.475ms  | ±0.77%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.285mb  | 13.546ms  | ±0.71%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.390mb  | 13.940ms  | ±0.84%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.057mb  | 3.149ms   | ±2.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.272mb  | 13.416ms  | ±0.51%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.323mb  | 13.476ms  | ±0.46%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.218mb  | 13.136ms  | ±0.39%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.308mb  | 10.172ms  | ±0.52%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.202mb  | 10.208ms  | ±0.09%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.353mb  | 11.749ms  | ±0.17%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.050mb  | 12.103ms  | ±0.22%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.535mb  | 10.945ms  | ±0.32%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.607mb  | 10.291ms  | ±0.09%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.852mb | 19.291ms  | ±0.26%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.752mb  | 3.027ms   | ±0.38%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.609μs  | ±0.58%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.506mb  | 243.734μs | ±0.58%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.408mb  | 4.326ms   | ±0.49%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.203mb  | 12.139ms  | ±1.07%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.611mb | 46.970ms  | ±0.52%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.214mb  | 3.747ms   | ±0.66%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.029mb  | 9.925ms   | ±0.29%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.802mb  | 8.915ms   | ±0.36%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.616mb  | 8.504ms   | ±0.35%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.825mb  | 8.539ms   | ±0.41%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.049μs   | ±16.64% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.986μs   | ±26.50% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.442mb | 16.011ms  | ±1.02%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.442mb | 16.074ms  | ±0.38%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```