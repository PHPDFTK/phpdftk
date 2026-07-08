# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-08 02:08:51 UTC
PHP: 8.4.23
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.722ms | 2.525ms | 2.768ms | 4.726ms | 7.053ms |
| FPDF | 792.828μs | 856.820μs | 954.315μs | 1.539ms | 2.296ms |
| TCPDF | 10.201ms | 11.116ms | 12.111ms | 19.332ms | 28.642ms |
| mPDF | 26.265ms | 29.682ms | 33.953ms | 61.812ms | 95.214ms |
| Dompdf | 11.337ms | 15.546ms | 20.421ms | 67.254ms | 148.837ms |

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
| phpdftk | 3.410ms | 3.617ms | 3.928ms | 5.894ms | 8.314ms |
| FPDF | 1.086ms | 1.177ms | 1.281ms | 1.969ms | 2.775ms |
| TCPDF | 17.901ms | 18.593ms | 19.765ms | 28.087ms | 38.825ms |

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
| Pdf (Level 3) | 3.383ms | 4.394ms | 12.423ms |
| PdfDoc (Level 2) | 2.664ms | 3.134ms | 7.517ms |
| PdfWriter (Level 1) | 2.346ms | 2.803ms | 6.928ms |

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
| Pdf (Level 3) | 4.380ms | 11.918ms | 46.049ms |
| PdfDoc (Level 2) | 3.822ms | 9.931ms | — |

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
| Pdf (Level 3) | 4.048ms | 11.600ms | 45.143ms |
| PdfDoc (Level 2) | 3.260ms | 7.244ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 5.970mb | 6.521mb | 8.965mb |
| PdfDoc (Level 2) | 5.758mb | 6.252mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.169ms | 1.671ms | 6.071ms |
| smalot/pdfparser | 2.041ms | 2.409ms | 5.602ms |
| setasign/fpdi | 1.924ms | 2.772ms | 28.637ms |

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
| phpdftk | 2.037ms | 1.387ms |
| smalot/pdfparser | FAIL | 1.942ms |
| setasign/fpdi | 2.939ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.274ms   | ±1.60%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.671ms   | ±0.38%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.594mb  | 6.071ms   | ±0.77%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.037ms   | ±0.78%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.387ms   | ±0.85%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.807mb  | 2.041ms   | ±1.63%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.891mb  | 2.409ms   | ±0.68%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.602ms   | ±1.47%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 575.192μs | ±1.00%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.801mb  | 1.942ms   | ±0.56%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.742mb  | 1.924ms   | ±0.82%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.772ms   | ±1.97%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 28.637ms  | ±1.12%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.939ms   | ±3.89%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.539ms   | ±0.46%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.951mb  | 7.246ms   | ±1.20%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.923mb  | 5.494ms   | ±0.87%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.967mb  | 3.890ms   | ±1.15%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 4.493μs   | ±23.45% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.169ms   | ±0.48%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.056mb | 49.983ms  | ±0.10%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 14.644mb | 99.753ms  | ±0.37%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.049mb | 1.182s    | ±0.27%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.701mb | 25.593ms  | ±18.86% |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.727mb | 55.137ms  | ±1.42%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.473mb | 506.711ms | ±0.90%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 28.985mb | 64.656ms  | ±11.37% |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.638mb | 82.575ms  | ±1.15%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.407mb | 670.478ms | ±0.75%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.749mb | 18.487ms  | ±1.35%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.749mb | 42.130ms  | ±3.39%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.391mb | 278.825ms | ±0.52%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.337mb  | 4.380ms   | ±9.62%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.133mb  | 11.918ms  | ±0.11%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.541mb | 46.049ms  | ±1.14%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.144mb  | 3.822ms   | ±1.06%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 8.959mb  | 9.931ms   | ±0.53%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.333mb | 72.030ms  | ±1.05%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 19.942mb | 309.454ms | ±0.29%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 43.562mb | 1.204s    | ±0.64%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.377mb | 220.752ms | ±0.34%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 30.708mb | 183.032ms | ±0.43%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.120mb | 139.546ms | ±0.58%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.156mb | 186.910ms | ±0.45%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 15.714mb | 151.164ms | ±0.86%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.192mb | 289.403ms | ±0.62%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 13.793mb | 45.147ms  | ±0.15%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 13.778mb | 39.261ms  | ±0.84%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 13.708mb | 37.997ms  | ±0.42%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 14.944mb | 123.092ms | ±0.29%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 13.701mb | 41.388ms  | ±0.64%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 13.979mb | 52.132ms  | ±0.07%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 14.394mb | 76.432ms  | ±0.32%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 13.673mb | 33.054ms  | ±0.82%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 13.926mb | 41.831ms  | ±1.35%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.056mb | 194.942ms | ±0.46%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.239mb | 159.173ms | ±0.36%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.732mb  | 8.831ms   | ±0.35%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.546mb  | 8.299ms   | ±0.61%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.755mb  | 8.413ms   | ±0.45%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.381mb  | 2.346ms   | ±0.61%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.540mb  | 2.803ms   | ±0.54%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.115mb  | 6.928ms   | ±1.20%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.643mb  | 2.664ms   | ±0.34%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.802mb  | 3.134ms   | ±0.63%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.370mb  | 7.517ms   | ±0.65%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 5.986mb  | 3.383ms   | ±1.07%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.150mb  | 4.394ms   | ±1.44%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.826mb  | 12.423ms  | ±0.72%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 5.970mb  | 4.048ms   | ±0.72%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.521mb  | 11.600ms  | ±0.58%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 8.965mb  | 45.143ms  | ±0.55%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.758mb  | 3.260ms   | ±1.26%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.252mb  | 7.244ms   | ±0.61%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.242mb  | 2.166μs   | ±18.00% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.242mb  | 2.344μs   | ±33.38% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.320mb | 14.737ms  | ±0.80%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.320mb | 14.564ms  | ±0.04%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.878mb  | 2.317ms   | ±0.81%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.938mb  | 2.525ms   | ±1.75%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.024mb  | 2.768ms   | ±0.80%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.659mb  | 4.726ms   | ±1.39%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.481mb  | 7.053ms   | ±0.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.280mb  | 3.491ms   | ±1.28%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.334mb  | 3.803ms   | ±0.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.771mb  | 12.824ms  | ±1.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.323mb  | 3.659ms   | ±1.07%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.666mb  | 2.382ms   | ±2.16%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 623.662μs | ±1.99%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.096mb  | 3.143ms   | ±2.05%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.190mb  | 3.597ms   | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.110mb  | 3.195ms   | ±0.68%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.166mb  | 208.671ms | ±28.57% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.227mb  | 3.562ms   | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.842mb  | 5.900ms   | ±1.28%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.974mb  | 6.019ms   | ±1.32%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.201ms  | ±0.97%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.116ms  | ±0.47%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.111ms  | ±1.13%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 19.332ms  | ±0.60%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 28.642ms  | ±0.39%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 792.828μs | ±3.04%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.073mb  | 856.820μs | ±1.36%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.073mb  | 954.315μs | ±1.25%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.073mb  | 1.539ms   | ±0.55%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.083mb  | 2.296ms   | ±1.24%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 26.265ms  | ±1.51%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.682mb | 29.682ms  | ±1.12%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.953ms  | ±0.63%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 61.812ms  | ±0.66%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.375mb | 95.214ms  | ±0.36%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.337ms  | ±0.34%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.546ms  | ±0.93%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 20.421ms  | ±0.56%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 67.254ms  | ±0.61%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.953mb | 148.837ms | ±0.18%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.040mb  | 5.014ms   | ±3.40%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.487mb  | 53.203ms  | ±0.84%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.678μs   | ±9.07%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.058mb  | 197.430ms | ±15.80% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 500.615μs | ±0.74%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.454mb  | 2.965ms   | ±0.94%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.052mb  | 3.375ms   | ±0.44%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 11.923ms  | ±6.25%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 82.844ms  | ±0.83%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 15.403ms  | ±0.90%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.692ms  | ±0.90%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.887mb  | 252.441ms | ±12.09% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.218mb  | 14.262ms  | ±5.84%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.190mb  | 13.723ms  | ±0.89%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.199mb  | 14.069ms  | ±0.68%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.215mb  | 14.155ms  | ±1.18%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.320mb  | 14.495ms  | ±0.23%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 5.987mb  | 2.963ms   | ±1.49%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.202mb  | 14.182ms  | ±0.79%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.253mb  | 14.235ms  | ±1.05%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.148mb  | 13.722ms  | ±0.99%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.365mb  | 3.410ms   | ±1.32%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.411mb  | 3.617ms   | ±0.97%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.470mb  | 3.928ms   | ±1.26%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.963mb  | 5.894ms   | ±0.26%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.562mb  | 8.314ms   | ±0.96%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.901ms  | ±0.76%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.593ms  | ±0.83%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.765ms  | ±0.61%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 28.087ms  | ±0.11%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.487mb | 38.825ms  | ±0.30%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.086ms   | ±0.61%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.177ms   | ±1.20%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.281ms   | ±0.52%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.969ms   | ±0.94%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.504mb  | 2.775ms   | ±1.08%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.163mb  | 9.525ms   | ±0.38%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 8.646mb  | 9.627ms   | ±0.22%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.800mb  | 11.257ms  | ±0.13%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.906mb  | 11.135ms  | ±0.91%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.325mb  | 10.769ms  | ±0.79%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.462mb  | 9.774ms   | ±0.31%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.643mb | 17.789ms  | ±0.42%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.710mb  | 2.971ms   | ±0.08%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 42.266μs  | ±0.77%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.497mb  | 236.536μs | ±0.17%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.247mb  | 22.987ms  | ±0.45%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.233mb | 202.161ms | ±0.44%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.748mb | 1.003s    | ±0.81%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```