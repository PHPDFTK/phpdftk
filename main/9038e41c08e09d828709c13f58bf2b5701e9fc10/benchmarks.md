# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-08 02:12:22 UTC
PHP: 8.4.23
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.206ms | 2.562ms | 2.780ms | 4.760ms | 7.131ms |
| FPDF | 775.032μs | 848.397μs | 938.785μs | 1.533ms | 2.270ms |
| TCPDF | 10.309ms | 11.035ms | 12.111ms | 20.789ms | 31.294ms |
| mPDF | 25.692ms | 30.027ms | 34.279ms | 66.397ms | 105.592ms |
| Dompdf | 11.566ms | 16.535ms | 21.942ms | 74.820ms | 164.897ms |

## Peak Memory — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 9.148mb | 5.938mb | 6.024mb | 6.659mb | 7.481mb |
| FPDF | 5.072mb | 5.073mb | 5.073mb | 5.073mb | 5.083mb |
| TCPDF | 12.912mb | 12.912mb | 12.912mb | 12.912mb | 12.912mb |
| mPDF | 17.624mb | 17.682mb | 17.721mb | 18.014mb | 18.375mb |
| Dompdf | 9.357mb | 9.577mb | 9.898mb | 12.591mb | 15.953mb |

## Generation Time — `MemoryBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 3.399ms | 3.592ms | 3.863ms | 5.923ms | 8.432ms |
| FPDF | 1.035ms | 1.134ms | 1.250ms | 1.947ms | 2.762ms |
| TCPDF | 17.287ms | 18.865ms | 19.729ms | 29.474ms | 41.956ms |

## Peak Memory — `MemoryBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 5.365mb | 5.411mb | 5.470mb | 5.963mb | 6.562mb |
| FPDF | 4.455mb | 4.455mb | 4.455mb | 4.455mb | 4.504mb |
| TCPDF | 12.487mb | 12.487mb | 12.487mb | 12.487mb | 12.487mb |

## Writer Levels Comparison — `WriterLevelsBench`

Same workload (N pages with heading + body text) rendered through each
writer level, so the abstraction overhead is visible directly. Lower is
better; the higher-level APIs (`Pdf` → `PdfDoc` → `PdfWriter`) trade
some performance for ergonomics.

### Generation Time

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| Pdf (Level 3) | 3.279ms | 4.357ms | 12.763ms |
| PdfDoc (Level 2) | 2.623ms | 3.097ms | 7.484ms |
| PdfWriter (Level 1) | 2.342ms | 2.767ms | 6.972ms |

### Peak Memory

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| Pdf (Level 3) | 5.986mb | 6.150mb | 7.826mb |
| PdfDoc (Level 2) | 5.643mb | 5.802mb | 7.370mb |
| PdfWriter (Level 1) | 5.381mb | 5.540mb | 7.115mb |

## Tables — `TablesBench`

Table rendering through `Pdf::addTable()` (Level 3, flow-paginated)
and `Writer\Page::drawTable()` (Level 2, positioned). Both share the
same underlying `TableRenderer`; the delta isolates the cost of the
flow-layout engine.

### Generation Time

| Library | 10 rows | 100 rows | 500 rows |
|---|---|---|---|
| Pdf (Level 3) | 4.323ms | 12.074ms | 47.586ms |
| PdfDoc (Level 2) | 3.698ms | 10.025ms | — |

### Peak Memory

| Library | 10 rows | 100 rows | 500 rows |
|---|---|---|---|
| Pdf (Level 3) | 6.337mb | 9.133mb | 21.541mb |
| PdfDoc (Level 2) | 6.144mb | 8.959mb | — |

## Lists — `ListsBench`

Bullet-list rendering through `Pdf::addList()` (Level 3) and
`Writer\Page::drawList()` (Level 2). Both share `ListRenderer`.

### Generation Time

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 4.034ms | 11.738ms | 45.647ms |
| PdfDoc (Level 2) | 3.212ms | 7.254ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 5.970mb | 6.521mb | 8.965mb |
| PdfDoc (Level 2) | 5.758mb | 6.252mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.304ms | 1.694ms | 6.007ms |
| smalot/pdfparser | 2.009ms | 2.376ms | 5.794ms |
| setasign/fpdi | 1.997ms | 2.950ms | 30.310ms |

## Peak Memory — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 5.341mb | 4.243mb | 4.594mb |
| smalot/pdfparser | 4.807mb | 4.891mb | 6.601mb |
| setasign/fpdi | 4.742mb | 4.769mb | 5.526mb |

## Compatibility — `ReadPdfBench`

Parse time for PDFs using spec-compliant features. `FAIL` = parser threw an exception.

| Library | Spec-compliant xref (20-byte SP CR LF) | Cross-reference stream (PDF 1.5) |
|---|---|---|
| phpdftk | 2.040ms | 1.383ms |
| smalot/pdfparser | FAIL | 1.943ms |
| setasign/fpdi | 3.042ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.300ms   | ±2.21%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.694ms   | ±2.79%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.594mb  | 6.007ms   | ±0.40%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.040ms   | ±3.78%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.383ms   | ±1.14%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.807mb  | 2.009ms   | ±0.83%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.891mb  | 2.376ms   | ±1.17%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.794ms   | ±5.24%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 558.800μs | ±1.01%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.801mb  | 1.943ms   | ±0.74%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.742mb  | 1.997ms   | ±2.65%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.950ms   | ±1.13%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 30.310ms  | ±1.71%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.042ms   | ±1.58%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.561ms   | ±1.82%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.951mb  | 7.283ms   | ±1.23%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.923mb  | 5.503ms   | ±1.14%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.967mb  | 3.908ms   | ±1.14%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.697μs   | ±18.25% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.304ms   | ±0.99%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.056mb | 51.454ms  | ±0.44%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 14.644mb | 106.264ms | ±0.33%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.049mb | 1.272s    | ±0.49%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.701mb | 26.699ms  | ±9.22%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.727mb | 59.622ms  | ±1.13%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.473mb | 553.536ms | ±0.97%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 28.985mb | 65.001ms  | ±8.75%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.638mb | 86.901ms  | ±3.34%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.407mb | 738.964ms | ±1.23%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.749mb | 18.914ms  | ±2.36%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.749mb | 42.968ms  | ±0.29%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.391mb | 323.120ms | ±0.49%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.337mb  | 4.323ms   | ±0.63%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.133mb  | 12.074ms  | ±1.00%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.541mb | 47.586ms  | ±3.74%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.144mb  | 3.698ms   | ±0.32%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 8.959mb  | 10.025ms  | ±0.68%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.333mb | 76.805ms  | ±5.08%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 19.942mb | 335.116ms | ±0.98%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 43.562mb | 1.311s    | ±0.67%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.377mb | 238.602ms | ±0.88%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 30.708mb | 184.380ms | ±1.89%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.120mb | 147.831ms | ±0.57%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.156mb | 200.115ms | ±0.44%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 15.714mb | 164.832ms | ±0.29%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.192mb | 313.702ms | ±0.85%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 13.793mb | 48.360ms  | ±1.19%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 13.778mb | 41.961ms  | ±1.39%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 13.708mb | 39.697ms  | ±1.40%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 14.944mb | 132.038ms | ±0.41%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 13.701mb | 43.623ms  | ±0.27%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 13.979mb | 55.100ms  | ±0.42%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 14.394mb | 81.596ms  | ±0.95%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 13.673mb | 34.797ms  | ±0.31%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 13.926mb | 43.017ms  | ±0.59%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.056mb | 210.150ms | ±0.53%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.239mb | 167.069ms | ±0.57%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.732mb  | 8.909ms   | ±0.77%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.546mb  | 8.452ms   | ±0.57%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.755mb  | 8.599ms   | ±1.07%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.381mb  | 2.342ms   | ±0.62%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.540mb  | 2.767ms   | ±1.19%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.115mb  | 6.972ms   | ±0.55%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.643mb  | 2.623ms   | ±4.48%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.802mb  | 3.097ms   | ±0.72%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.370mb  | 7.484ms   | ±0.44%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 5.986mb  | 3.279ms   | ±0.88%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.150mb  | 4.357ms   | ±0.87%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.826mb  | 12.763ms  | ±0.34%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 5.970mb  | 4.034ms   | ±0.78%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.521mb  | 11.738ms  | ±0.89%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 8.965mb  | 45.647ms  | ±0.64%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.758mb  | 3.212ms   | ±2.94%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.252mb  | 7.254ms   | ±0.76%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.242mb  | 2.036μs   | ±12.86% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.242mb  | 2.073μs   | ±23.57% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.320mb | 14.731ms  | ±0.08%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.320mb | 15.035ms  | ±0.91%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.878mb  | 2.333ms   | ±0.91%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.938mb  | 2.562ms   | ±0.82%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.024mb  | 2.780ms   | ±0.48%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.659mb  | 4.760ms   | ±0.61%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.481mb  | 7.131ms   | ±0.65%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.280mb  | 3.560ms   | ±1.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.334mb  | 3.953ms   | ±1.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.771mb  | 12.614ms  | ±16.27% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.323mb  | 3.745ms   | ±0.64%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.666mb  | 2.421ms   | ±59.29% |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 635.526μs | ±1.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.096mb  | 3.214ms   | ±0.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.190mb  | 3.660ms   | ±0.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.110mb  | 3.264ms   | ±0.55%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.166mb  | 173.396ms | ±18.51% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.227mb  | 3.599ms   | ±0.74%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.842mb  | 5.858ms   | ±21.70% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.974mb  | 6.117ms   | ±0.65%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.309ms  | ±1.83%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.035ms  | ±1.20%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.111ms  | ±0.69%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.789ms  | ±0.51%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.294ms  | ±1.51%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 775.032μs | ±1.47%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.073mb  | 848.397μs | ±0.56%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.073mb  | 938.785μs | ±39.34% |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.073mb  | 1.533ms   | ±1.41%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.083mb  | 2.270ms   | ±1.04%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.692ms  | ±1.75%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.682mb | 30.027ms  | ±0.47%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 34.279ms  | ±1.14%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 66.397ms  | ±0.57%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.375mb | 105.592ms | ±0.72%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.566ms  | ±1.84%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.535ms  | ±0.24%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.942ms  | ±1.86%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 74.820ms  | ±1.12%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.953mb | 164.897ms | ±0.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.040mb  | 5.151ms   | ±0.93%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.487mb  | 50.342ms  | ±0.95%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.058mb  | 207.395ms | ±34.11% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 464.577μs | ±1.43%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.454mb  | 3.034ms   | ±0.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.052mb  | 3.438ms   | ±1.37%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 13.644ms  | ±5.87%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 87.894ms  | ±0.68%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.937ms  | ±0.61%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.030ms  | ±0.80%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.887mb  | 192.451ms | ±11.19% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.218mb  | 13.593ms  | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.190mb  | 13.390ms  | ±0.68%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.199mb  | 13.447ms  | ±0.41%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.215mb  | 13.580ms  | ±0.54%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.320mb  | 14.138ms  | ±0.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 5.987mb  | 2.939ms   | ±0.84%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.202mb  | 13.431ms  | ±0.50%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.253mb  | 13.623ms  | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.148mb  | 13.206ms  | ±0.72%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.365mb  | 3.399ms   | ±0.50%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.411mb  | 3.592ms   | ±0.30%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.470mb  | 3.863ms   | ±0.41%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.963mb  | 5.923ms   | ±1.51%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.562mb  | 8.432ms   | ±0.70%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.287ms  | ±0.33%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.865ms  | ±2.50%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.729ms  | ±0.83%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.474ms  | ±1.75%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.487mb | 41.956ms  | ±0.40%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.035ms   | ±1.25%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.134ms   | ±0.84%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.250ms   | ±1.53%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.947ms   | ±0.62%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.504mb  | 2.762ms   | ±0.31%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.163mb  | 10.047ms  | ±0.55%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 8.646mb  | 10.166ms  | ±0.77%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.800mb  | 11.675ms  | ±0.92%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.906mb  | 11.815ms  | ±0.64%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.325mb  | 11.016ms  | ±0.84%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.462mb  | 10.345ms  | ±0.87%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.643mb | 19.228ms  | ±0.20%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.710mb  | 3.062ms   | ±1.76%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.565μs  | ±0.97%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.497mb  | 243.435μs | ±0.59%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.247mb  | 24.605ms  | ±0.45%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.233mb | 222.301ms | ±0.75%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.748mb | 1.083s    | ±2.31%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```