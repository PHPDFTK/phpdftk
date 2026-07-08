# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-08 02:04:54 UTC
PHP: 8.4.23
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.411ms | 2.504ms | 2.777ms | 4.814ms | 7.081ms |
| FPDF | 797.239μs | 849.793μs | 926.212μs | 1.496ms | 2.252ms |
| TCPDF | 9.915ms | 10.859ms | 12.137ms | 20.620ms | 31.304ms |
| mPDF | 25.240ms | 29.245ms | 32.950ms | 65.260ms | 105.121ms |
| Dompdf | 11.333ms | 16.138ms | 21.659ms | 74.100ms | 164.400ms |

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
| phpdftk | 3.365ms | 3.593ms | 3.836ms | 5.900ms | 8.416ms |
| FPDF | 1.074ms | 1.118ms | 1.221ms | 1.913ms | 2.769ms |
| TCPDF | 17.387ms | 18.110ms | 19.628ms | 29.198ms | 42.212ms |

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
| Pdf (Level 3) | 3.288ms | 4.341ms | 12.610ms |
| PdfDoc (Level 2) | 2.651ms | 3.057ms | 7.484ms |
| PdfWriter (Level 1) | 2.318ms | 2.759ms | 6.935ms |

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
| Pdf (Level 3) | 4.308ms | 12.194ms | 47.062ms |
| PdfDoc (Level 2) | 3.712ms | 9.918ms | — |

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
| Pdf (Level 3) | 3.999ms | 11.684ms | 45.069ms |
| PdfDoc (Level 2) | 3.209ms | 7.252ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 5.970mb | 6.521mb | 8.965mb |
| PdfDoc (Level 2) | 5.758mb | 6.252mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.243ms | 1.678ms | 6.072ms |
| smalot/pdfparser | 2.003ms | 2.386ms | 5.870ms |
| setasign/fpdi | 1.958ms | 2.853ms | 29.600ms |

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
| phpdftk | 2.053ms | 1.382ms |
| smalot/pdfparser | FAIL | 1.934ms |
| setasign/fpdi | 3.007ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.246ms   | ±1.71%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.678ms   | ±1.33%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.594mb  | 6.072ms   | ±0.40%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.053ms   | ±0.63%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.382ms   | ±0.57%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.807mb  | 2.003ms   | ±1.14%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.891mb  | 2.386ms   | ±1.79%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.870ms   | ±1.01%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 558.147μs | ±1.14%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.801mb  | 1.934ms   | ±0.66%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.742mb  | 1.958ms   | ±0.80%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.853ms   | ±0.48%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.600ms  | ±0.67%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.007ms   | ±0.86%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.545ms   | ±0.77%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.951mb  | 7.269ms   | ±0.62%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.923mb  | 5.467ms   | ±0.45%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.967mb  | 3.849ms   | ±0.37%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.386μs   | ±16.56% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.243ms   | ±1.05%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 13.732mb | 50.856ms  | ±0.57%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 14.320mb | 104.372ms | ±0.24%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 40.807mb | 1.272s    | ±0.24%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.543mb | 26.655ms  | ±11.30% |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.569mb | 59.231ms  | ±1.15%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.315mb | 540.866ms | ±0.39%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 28.171mb | 65.448ms  | ±10.98% |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 22.825mb | 86.008ms  | ±1.59%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.249mb | 737.127ms | ±0.61%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.525mb | 19.161ms  | ±6.84%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.525mb | 43.157ms  | ±0.23%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.233mb | 323.896ms | ±0.62%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.337mb  | 4.308ms   | ±2.98%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.133mb  | 12.194ms  | ±0.94%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.541mb | 47.062ms  | ±0.58%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.144mb  | 3.712ms   | ±1.43%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 8.959mb  | 9.918ms   | ±0.47%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 13.943mb | 76.205ms  | ±0.84%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 19.716mb | 333.477ms | ±0.51%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 43.336mb | 1.300s    | ±0.79%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.150mb | 230.636ms | ±0.75%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 30.482mb | 179.566ms | ±0.55%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 14.729mb | 145.830ms | ±0.43%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 15.766mb | 197.618ms | ±0.07%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 15.389mb | 161.310ms | ±0.32%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 17.801mb | 320.315ms | ±2.09%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 13.468mb | 47.142ms  | ±0.23%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 13.388mb | 41.243ms  | ±0.53%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 13.318mb | 39.256ms  | ±0.22%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 14.619mb | 130.074ms | ±0.87%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 13.376mb | 43.288ms  | ±0.22%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 13.588mb | 54.451ms  | ±0.53%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 14.004mb | 81.279ms  | ±0.54%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 13.283mb | 34.420ms  | ±0.04%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 13.700mb | 42.398ms  | ±0.44%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 16.829mb | 204.515ms | ±0.52%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 13.849mb | 166.378ms | ±0.37%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.732mb  | 8.846ms   | ±0.83%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.546mb  | 8.423ms   | ±0.65%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.755mb  | 8.569ms   | ±0.83%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.381mb  | 2.318ms   | ±2.12%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.540mb  | 2.759ms   | ±1.59%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.115mb  | 6.935ms   | ±3.02%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.643mb  | 2.651ms   | ±3.81%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.802mb  | 3.057ms   | ±0.29%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.370mb  | 7.484ms   | ±0.64%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 5.986mb  | 3.288ms   | ±0.55%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.150mb  | 4.341ms   | ±0.40%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.826mb  | 12.610ms  | ±0.36%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 5.970mb  | 3.999ms   | ±0.57%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.521mb  | 11.684ms  | ±1.16%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 8.965mb  | 45.069ms  | ±0.46%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.758mb  | 3.209ms   | ±0.89%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.252mb  | 7.252ms   | ±4.52%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.242mb  | 2.049μs   | ±16.64% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.242mb  | 1.976μs   | ±23.16% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 12.930mb | 14.500ms  | ±0.57%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 12.930mb | 14.505ms  | ±0.67%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.878mb  | 2.327ms   | ±3.23%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.938mb  | 2.504ms   | ±33.22% |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.024mb  | 2.777ms   | ±0.52%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.659mb  | 4.814ms   | ±0.67%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.481mb  | 7.081ms   | ±0.56%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.280mb  | 3.528ms   | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.334mb  | 3.824ms   | ±0.34%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.771mb  | 12.500ms  | ±13.02% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.323mb  | 3.678ms   | ±1.20%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.666mb  | 2.394ms   | ±0.81%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 640.725μs | ±1.78%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.096mb  | 3.216ms   | ±6.34%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.190mb  | 3.665ms   | ±0.97%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.110mb  | 3.238ms   | ±0.96%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.166mb  | 199.019ms | ±24.78% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.227mb  | 3.603ms   | ±0.86%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.842mb  | 5.773ms   | ±47.23% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.974mb  | 6.003ms   | ±0.89%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.915ms   | ±0.99%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.859ms  | ±0.73%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.137ms  | ±1.26%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.620ms  | ±0.51%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.304ms  | ±0.54%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 797.239μs | ±4.89%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.073mb  | 849.793μs | ±1.11%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.073mb  | 926.212μs | ±2.80%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.073mb  | 1.496ms   | ±0.90%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.083mb  | 2.252ms   | ±0.68%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.240ms  | ±1.53%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.682mb | 29.245ms  | ±0.93%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.950ms  | ±0.74%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.260ms  | ±0.49%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.375mb | 105.121ms | ±0.63%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.333ms  | ±1.28%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.138ms  | ±0.47%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.659ms  | ±0.56%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 74.100ms  | ±0.72%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.953mb | 164.400ms | ±0.74%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.040mb  | 5.135ms   | ±1.61%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.487mb  | 50.302ms  | ±0.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.344μs   | ±11.13% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.624μs   | ±18.18% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.058mb  | 181.663ms | ±16.75% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 461.216μs | ±1.02%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.454mb  | 3.021ms   | ±0.41%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.052mb  | 3.439ms   | ±0.61%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 12.928ms  | ±4.12%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 87.027ms  | ±0.31%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.259ms  | ±1.75%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 24.737ms  | ±1.24%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.887mb  | 269.420ms | ±20.59% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.218mb  | 13.521ms  | ±0.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.190mb  | 13.468ms  | ±0.56%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.199mb  | 13.443ms  | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.215mb  | 13.571ms  | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.320mb  | 14.053ms  | ±0.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 5.987mb  | 2.973ms   | ±1.91%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.202mb  | 13.458ms  | ±2.56%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.253mb  | 13.618ms  | ±2.45%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.148mb  | 13.411ms  | ±0.88%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.365mb  | 3.365ms   | ±0.58%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.411mb  | 3.593ms   | ±0.53%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.470mb  | 3.836ms   | ±0.69%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.963mb  | 5.900ms   | ±0.38%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.562mb  | 8.416ms   | ±0.11%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.387ms  | ±0.70%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.110ms  | ±0.83%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.628ms  | ±2.48%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.198ms  | ±3.11%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.487mb | 42.212ms  | ±0.94%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.074ms   | ±8.50%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.118ms   | ±2.04%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.221ms   | ±1.86%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.913ms   | ±3.59%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.504mb  | 2.769ms   | ±0.31%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.127mb  | 9.952ms   | ±1.59%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 8.545mb  | 10.017ms  | ±1.58%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.764mb  | 11.456ms  | ±0.17%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.870mb  | 11.693ms  | ±0.26%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.289mb  | 10.804ms  | ±0.44%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.426mb  | 10.058ms  | ±0.71%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.607mb | 18.997ms  | ±1.58%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.685mb  | 2.939ms   | ±1.24%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.336μs  | ±2.41%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.497mb  | 244.729μs | ±6.57%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.227mb  | 24.396ms  | ±0.15%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.212mb | 220.331ms | ±1.06%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.728mb | 1.075s    | ±1.30%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```