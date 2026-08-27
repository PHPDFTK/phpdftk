# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-27 05:49:18 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.523ms | 2.542ms | 2.764ms | 4.772ms | 7.101ms |
| FPDF | 780.226μs | 848.913μs | 922.727μs | 1.599ms | 2.261ms |
| TCPDF | 9.952ms | 11.000ms | 12.063ms | 20.726ms | 31.233ms |
| mPDF | 25.190ms | 28.990ms | 33.123ms | 65.626ms | 105.235ms |
| Dompdf | 11.393ms | 15.923ms | 21.579ms | 73.555ms | 163.453ms |

## Peak Memory — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 9.213mb | 5.943mb | 6.029mb | 6.663mb | 7.485mb |
| FPDF | 5.072mb | 5.072mb | 5.072mb | 5.072mb | 5.084mb |
| TCPDF | 12.912mb | 12.912mb | 12.912mb | 12.912mb | 12.912mb |
| mPDF | 17.624mb | 17.683mb | 17.721mb | 18.014mb | 18.376mb |
| Dompdf | 9.357mb | 9.577mb | 9.898mb | 12.591mb | 15.954mb |

## Generation Time — `MemoryBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 3.394ms | 3.639ms | 3.892ms | 5.861ms | 8.337ms |
| FPDF | 1.027ms | 1.099ms | 1.231ms | 1.898ms | 2.762ms |
| TCPDF | 17.282ms | 18.329ms | 19.583ms | 29.328ms | 41.858ms |

## Peak Memory — `MemoryBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 5.369mb | 5.416mb | 5.475mb | 5.967mb | 6.566mb |
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
| Pdf (Level 3) | 3.355ms | 4.428ms | 12.578ms |
| PdfDoc (Level 2) | 2.705ms | 3.165ms | 7.519ms |
| PdfWriter (Level 1) | 2.328ms | 2.812ms | 6.918ms |

### Peak Memory

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| Pdf (Level 3) | 6.052mb | 6.216mb | 7.892mb |
| PdfDoc (Level 2) | 5.709mb | 5.868mb | 7.436mb |
| PdfWriter (Level 1) | 5.385mb | 5.544mb | 7.119mb |

## Tables — `TablesBench`

Table rendering through `Pdf::addTable()` (Level 3, flow-paginated)
and `Writer\Page::drawTable()` (Level 2, positioned). Both share the
same underlying `TableRenderer`; the delta isolates the cost of the
flow-layout engine.

### Generation Time

| Library | 10 rows | 100 rows | 500 rows |
|---|---|---|---|
| Pdf (Level 3) | 4.412ms | 12.225ms | 46.926ms |
| PdfDoc (Level 2) | 3.850ms | 10.003ms | — |

### Peak Memory

| Library | 10 rows | 100 rows | 500 rows |
|---|---|---|---|
| Pdf (Level 3) | 6.403mb | 9.198mb | 21.607mb |
| PdfDoc (Level 2) | 6.210mb | 9.025mb | — |

## Lists — `ListsBench`

Bullet-list rendering through `Pdf::addList()` (Level 3) and
`Writer\Page::drawList()` (Level 2). Both share `ListRenderer`.

### Generation Time

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 4.179ms | 12.010ms | 45.612ms |
| PdfDoc (Level 2) | 3.365ms | 7.394ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.255ms | 1.683ms | 6.030ms |
| smalot/pdfparser | 2.026ms | 2.397ms | 5.829ms |
| setasign/fpdi | 1.942ms | 2.847ms | 29.879ms |

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
| phpdftk | 2.052ms | 1.378ms |
| smalot/pdfparser | FAIL | 1.953ms |
| setasign/fpdi | 3.021ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 10.336ms  | ±1.48%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 10.586ms  | ±1.53%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 12.136ms  | ±0.95%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 12.183ms  | ±0.55%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 11.252ms  | ±1.36%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 10.638ms  | ±0.42%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 19.563ms  | ±0.03%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 3.032ms   | ±0.75%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.179ms   | ±0.79%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 12.010ms  | ±8.37%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.612ms  | ±12.42% |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.365ms   | ±0.82%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.394ms   | ±1.92%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.966μs   | ±19.64% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.073μs   | ±23.57% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.212mb | 16.230ms  | ±0.73%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.212mb | 16.000ms  | ±0.51%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.014mb | 55.626ms  | ±0.86%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.605mb | 112.588ms | ±1.36%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.261mb | 1.364s    | ±0.50%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.182mb | 26.092ms  | ±2.29%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.208mb | 60.235ms  | ±2.18%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.019mb | 533.235ms | ±0.95%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.465mb | 63.714ms  | ±9.65%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.185mb | 86.268ms  | ±1.42%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.954mb | 736.320ms | ±0.57%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.230mb | 18.876ms  | ±3.18%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.230mb | 43.020ms  | ±0.51%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.873mb | 325.226ms | ±0.68%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.412ms   | ±9.04%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.225ms  | ±1.73%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 46.926ms  | ±0.78%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.850ms   | ±1.32%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.003ms  | ±0.54%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.237ms   | ±1.66%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.683ms   | ±1.03%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.030ms   | ±3.25%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.052ms   | ±2.53%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.378ms   | ±1.09%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.026ms   | ±0.71%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.397ms   | ±1.89%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.829ms   | ±1.39%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 546.613μs | ±1.74%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.953ms   | ±9.99%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.942ms   | ±0.51%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.847ms   | ±0.53%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.879ms  | ±0.68%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.021ms   | ±1.39%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.517ms   | ±1.11%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.335ms   | ±1.21%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.474ms   | ±0.60%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.902ms   | ±0.94%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.517μs   | ±13.36% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.255ms   | ±0.94%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 25.645ms  | ±1.37%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 228.802ms | ±0.20%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 1.126s    | ±0.42%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.328ms   | ±1.47%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.812ms   | ±1.67%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.918ms   | ±0.61%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.705ms   | ±0.86%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.165ms   | ±0.87%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.519ms   | ±0.46%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.355ms   | ±0.85%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.428ms   | ±2.09%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.578ms  | ±4.61%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.298ms   | ±1.00%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.542ms   | ±0.88%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.764ms   | ±0.60%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.772ms   | ±0.42%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.101ms   | ±1.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.570ms   | ±1.57%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.868ms   | ±1.06%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.360ms  | ±17.40% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.675ms   | ±0.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.419ms   | ±4.40%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 640.974μs | ±4.13%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.181ms   | ±3.55%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.713ms   | ±1.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.259ms   | ±0.42%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 209.839ms | ±21.35% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.612ms   | ±0.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.934ms   | ±23.26% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.025ms   | ±0.97%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.952ms   | ±0.63%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.000ms  | ±2.54%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.063ms  | ±10.20% |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.726ms  | ±0.58%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.233ms  | ±0.35%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 780.226μs | ±11.38% |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 848.913μs | ±1.84%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 922.727μs | ±0.82%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.599ms   | ±2.93%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.261ms   | ±1.43%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.190ms  | ±1.91%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.990ms  | ±0.35%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.123ms  | ±6.22%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.626ms  | ±0.73%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 105.235ms | ±1.15%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.393ms  | ±1.30%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.923ms  | ±0.57%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.579ms  | ±0.29%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 73.555ms  | ±0.82%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 163.453ms | ±0.31%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.082ms   | ±2.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.254ms  | ±0.42%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.344μs   | ±11.13% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.333μs   | ±22.36% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 250.493ms | ±20.24% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 452.502μs | ±2.09%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.043ms   | ±1.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.398ms   | ±0.10%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 13.354ms  | ±4.56%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 86.434ms  | ±1.17%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.490ms  | ±1.41%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.281ms  | ±1.15%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 205.561ms | ±10.48% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.466ms  | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.556ms  | ±0.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.504ms  | ±1.29%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.663ms  | ±0.67%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 13.893ms  | ±0.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.264ms   | ±1.12%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.648ms  | ±0.17%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.587ms  | ±6.70%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.523ms  | ±6.92%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.394ms   | ±0.72%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.639ms   | ±0.48%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.892ms   | ±0.63%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.861ms   | ±0.27%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.337ms   | ±1.03%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.282ms  | ±0.50%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.329ms  | ±0.31%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.583ms  | ±0.49%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.328ms  | ±1.85%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.858ms  | ±0.77%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.027ms   | ±1.92%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.099ms   | ±3.76%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.231ms   | ±0.63%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.898ms   | ±0.47%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.762ms   | ±0.43%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 44.800μs  | ±13.52% |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 242.523μs | ±1.17%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.304mb | 82.805ms  | ±0.83%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.140mb | 361.847ms | ±0.37%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.803mb | 1.410s    | ±0.75%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.330mb | 248.203ms | ±0.45%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.913mb | 192.398ms | ±0.52%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.089mb | 157.775ms | ±0.31%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.140mb | 213.036ms | ±0.68%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.689mb | 178.028ms | ±1.86%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.184mb | 332.384ms | ±1.62%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.762mb | 50.886ms  | ±1.31%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.747mb | 44.154ms  | ±0.24%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.676mb | 41.697ms  | ±0.51%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.912mb | 139.043ms | ±0.60%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.671mb | 45.968ms  | ±0.83%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.948mb | 59.344ms  | ±0.72%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.365mb | 87.041ms  | ±1.12%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.643mb | 37.442ms  | ±0.24%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.580mb | 45.695ms  | ±1.65%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.608mb | 47.717ms  | ±0.32%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.577mb | 46.118ms  | ±2.11%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.599mb | 44.678ms  | ±5.29%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.567mb | 70.666ms  | ±1.02%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.620mb | 43.997ms  | ±1.77%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.297mb | 38.853ms  | ±0.55%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.545mb | 42.926ms  | ±1.96%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.566mb | 47.299ms  | ±0.50%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.559mb | 47.470ms  | ±0.71%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.788mb | 43.036ms  | ±1.46%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.931mb | 221.533ms | ±0.57%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.209mb | 173.481ms | ±0.49%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.083ms   | ±0.53%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.624ms   | ±1.08%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.721ms   | ±1.04%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```