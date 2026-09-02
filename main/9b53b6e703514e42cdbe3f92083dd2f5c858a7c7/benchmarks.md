# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-02 21:16:57 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.811ms | 2.495ms | 2.775ms | 4.701ms | 6.953ms |
| FPDF | 790.763μs | 873.105μs | 955.155μs | 1.537ms | 2.245ms |
| TCPDF | 10.161ms | 11.045ms | 11.942ms | 19.313ms | 28.541ms |
| mPDF | 26.532ms | 30.082ms | 33.184ms | 62.013ms | 96.034ms |
| Dompdf | 11.258ms | 15.312ms | 20.352ms | 66.553ms | 149.016ms |

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
| phpdftk | 3.349ms | 3.576ms | 3.961ms | 5.970ms | 8.276ms |
| FPDF | 1.062ms | 1.165ms | 1.254ms | 1.923ms | 2.732ms |
| TCPDF | 15.333ms | 15.983ms | 17.057ms | 25.151ms | 35.548ms |

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
| Pdf (Level 3) | 3.382ms | 4.363ms | 12.106ms |
| PdfDoc (Level 2) | 2.675ms | 3.148ms | 7.415ms |
| PdfWriter (Level 1) | 2.319ms | 2.772ms | 6.870ms |

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
| Pdf (Level 3) | 4.329ms | 11.922ms | 45.569ms |
| PdfDoc (Level 2) | 3.819ms | 9.947ms | — |

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
| Pdf (Level 3) | 4.035ms | 11.552ms | 44.318ms |
| PdfDoc (Level 2) | 3.317ms | 7.265ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.040mb | 6.592mb | 9.036mb |
| PdfDoc (Level 2) | 5.829mb | 6.323mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.127ms | 1.651ms | 6.084ms |
| smalot/pdfparser | 2.008ms | 2.375ms | 5.601ms |
| setasign/fpdi | 1.902ms | 2.706ms | 28.791ms |

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
| phpdftk | 2.033ms | 1.330ms |
| smalot/pdfparser | FAIL | 1.913ms |
| setasign/fpdi | 2.899ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.373mb  | 3.349ms   | ±1.56%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.420mb  | 3.576ms   | ±2.73%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.479mb  | 3.961ms   | ±18.98% |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.972mb  | 5.970ms   | ±0.60%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.570mb  | 8.276ms   | ±0.69%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 15.333ms  | ±3.64%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 15.983ms  | ±0.77%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 17.057ms  | ±0.71%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 25.151ms  | ±0.15%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 35.548ms  | ±0.71%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.062ms   | ±3.04%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.165ms   | ±1.42%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.254ms   | ±7.32%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.923ms   | ±0.62%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.732ms   | ±0.36%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.389mb  | 2.319ms   | ±1.22%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.548mb  | 2.772ms   | ±0.81%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.123mb  | 6.870ms   | ±2.94%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.714mb  | 2.675ms   | ±1.17%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.872mb  | 3.148ms   | ±0.40%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.441mb  | 7.415ms   | ±2.42%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.057mb  | 3.382ms   | ±1.11%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.220mb  | 4.363ms   | ±0.82%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.897mb  | 12.106ms  | ±0.24%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.435mb | 78.078ms  | ±4.00%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.222mb | 363.129ms | ±4.06%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.885mb | 1.307s    | ±0.81%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.452mb | 240.043ms | ±3.31%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 32.009mb | 193.338ms | ±0.78%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.224mb | 149.788ms | ±4.96%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.271mb | 202.126ms | ±5.11%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.820mb | 177.642ms | ±3.36%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.315mb | 315.256ms | ±3.45%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.959mb | 48.298ms  | ±4.14%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.878mb | 42.924ms  | ±3.62%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.807mb | 40.406ms  | ±2.73%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.114mb | 138.157ms | ±2.83%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.867mb | 44.594ms  | ±0.49%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 16.079mb | 59.854ms  | ±3.06%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.496mb | 82.227ms  | ±4.00%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.774mb | 35.801ms  | ±3.08%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.711mb | 43.918ms  | ±1.28%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.739mb | 45.429ms  | ±0.35%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.708mb | 45.920ms  | ±1.20%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.795mb | 43.440ms  | ±1.52%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.649mb | 68.822ms  | ±1.55%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.726mb | 43.794ms  | ±1.06%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.379mb | 37.136ms  | ±0.26%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.676mb | 40.793ms  | ±1.80%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.697mb | 46.136ms  | ±0.82%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.690mb | 45.328ms  | ±0.45%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.894mb | 42.280ms  | ±1.63%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 19.070mb | 207.856ms | ±1.71%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.340mb | 162.428ms | ±1.72%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.147mb | 53.113ms  | ±0.27%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.736mb | 107.115ms | ±3.40%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.375mb | 1.366s    | ±0.29%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.234mb | 23.921ms  | ±1.86%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.260mb | 52.794ms  | ±1.85%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.071mb | 459.230ms | ±1.16%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.518mb | 63.642ms  | ±10.33% |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.237mb | 83.577ms  | ±1.32%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 33.006mb | 657.264ms | ±0.99%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.283mb | 17.881ms  | ±1.44%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.283mb | 41.408ms  | ±0.77%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.925mb | 276.754ms | ±1.13%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.225ms   | ±1.75%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.651ms   | ±0.83%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.084ms   | ±1.60%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.033ms   | ±0.80%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.330ms   | ±2.97%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.008ms   | ±1.57%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.375ms   | ±0.73%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.601ms   | ±0.73%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 571.393μs | ±1.67%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.913ms   | ±0.56%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.902ms   | ±1.40%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.706ms   | ±2.24%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 28.791ms  | ±1.26%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.899ms   | ±0.77%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.525ms   | ±0.55%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.960mb  | 7.142ms   | ±0.29%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.932mb  | 5.349ms   | ±0.70%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.976mb  | 3.826ms   | ±0.38%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.832μs   | ±22.58% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.127ms   | ±1.35%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.472mb  | 24.202ms  | ±1.16%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.480mb | 219.790ms | ±8.77%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.098mb | 1.084s    | ±7.65%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.040mb  | 4.035ms   | ±0.96%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.592mb  | 11.552ms  | ±0.46%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.036mb  | 44.318ms  | ±0.91%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.829mb  | 3.317ms   | ±0.75%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.323mb  | 7.265ms   | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.886mb  | 2.294ms   | ±0.95%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.947mb  | 2.495ms   | ±0.79%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.033mb  | 2.775ms   | ±1.01%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.667mb  | 4.701ms   | ±0.69%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.490mb  | 6.953ms   | ±0.37%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.350mb  | 3.561ms   | ±2.07%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.342mb  | 3.764ms   | ±0.18%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.779mb  | 12.985ms  | ±0.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.394mb  | 3.629ms   | ±1.22%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.675mb  | 2.374ms   | ±0.55%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 603.862μs | ±2.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.104mb  | 3.112ms   | ±0.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.198mb  | 3.558ms   | ±0.93%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.119mb  | 3.137ms   | ±0.94%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.175mb  | 313.863ms | ±15.24% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.236mb  | 3.560ms   | ±0.70%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.851mb  | 5.769ms   | ±1.95%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.983mb  | 5.936ms   | ±0.61%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.161ms  | ±0.70%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.045ms  | ±1.28%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.942ms  | ±0.46%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 19.313ms  | ±0.62%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 28.541ms  | ±0.45%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 790.763μs | ±1.07%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 873.105μs | ±1.50%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 955.155μs | ±1.08%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.537ms   | ±0.77%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.245ms   | ±3.86%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 26.532ms  | ±1.10%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 30.082ms  | ±1.53%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.184ms  | ±0.97%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 62.013ms  | ±0.73%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 96.034ms  | ±0.58%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.258ms  | ±0.89%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.312ms  | ±0.90%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 20.352ms  | ±0.58%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 66.553ms  | ±1.26%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 149.016ms | ±0.77%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.049mb  | 4.986ms   | ±1.26%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.496mb  | 53.404ms  | ±0.68%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.667μs   | ±7.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.667μs   | ±7.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 275.880ms | ±35.25% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 486.909μs | ±0.84%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.463mb  | 2.890ms   | ±0.26%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.060mb  | 3.395ms   | ±1.19%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 12.493ms  | ±5.53%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 81.708ms  | ±1.19%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 15.221ms  | ±0.79%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 26.062ms  | ±0.40%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.896mb  | 207.494ms | ±18.75% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.288mb  | 13.855ms  | ±0.65%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.261mb  | 13.648ms  | ±0.35%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.269mb  | 13.951ms  | ±1.43%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.285mb  | 14.181ms  | ±1.99%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.390mb  | 14.376ms  | ±4.78%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.057mb  | 3.127ms   | ±0.79%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.272mb  | 14.003ms  | ±0.46%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.323mb  | 14.003ms  | ±1.05%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.218mb  | 13.811ms  | ±0.55%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.305mb  | 9.635ms   | ±0.86%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.199mb  | 9.832ms   | ±0.19%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.022mb  | 11.500ms  | ±0.67%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.047mb  | 11.188ms  | ±0.30%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.532mb  | 10.984ms  | ±0.63%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.604mb  | 9.948ms   | ±0.80%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.848mb | 17.805ms  | ±6.09%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.752mb  | 3.082ms   | ±0.93%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 43.117μs  | ±1.15%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.506mb  | 235.677μs | ±0.56%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.408mb  | 4.329ms   | ±0.60%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.203mb  | 11.922ms  | ±0.55%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.611mb | 45.569ms  | ±1.32%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.214mb  | 3.819ms   | ±1.72%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.029mb  | 9.947ms   | ±0.25%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.802mb  | 8.736ms   | ±1.20%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.616mb  | 8.366ms   | ±0.73%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.825mb  | 8.400ms   | ±0.48%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.317μs   | ±19.69% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.208μs   | ±30.21% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.408mb | 16.097ms  | ±0.52%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.408mb | 16.629ms  | ±2.33%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```