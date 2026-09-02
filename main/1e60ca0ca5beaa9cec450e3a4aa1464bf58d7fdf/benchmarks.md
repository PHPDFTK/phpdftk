# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-02 04:11:20 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 8.749ms | 1.918ms | 4.810ms | 4.942ms | 4.573ms |
| FPDF | 1.141ms | 2.385ms | 665.997μs | 4.594ms | 2.138ms |
| TCPDF | 7.350ms | 8.285ms | 14.550ms | 14.194ms | 20.572ms |
| mPDF | 19.126ms | 21.110ms | 22.417ms | 39.895ms | 62.023ms |
| Dompdf | 8.221ms | 10.363ms | 14.641ms | 43.181ms | 96.680ms |

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
| phpdftk | 3.988ms | 27.006ms | 2.819ms | 3.769ms | 7.399ms |
| FPDF | 792.330μs | 4.484ms | 917.786μs | 1.346ms | 1.923ms |
| TCPDF | 13.600ms | 15.411ms | 15.469ms | 19.175ms | 27.384ms |

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
| Pdf (Level 3) | 2.222ms | 3.015ms | 8.212ms |
| PdfDoc (Level 2) | 1.760ms | 2.003ms | 4.985ms |
| PdfWriter (Level 1) | 1.571ms | 1.948ms | 4.520ms |

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
| Pdf (Level 3) | 2.924ms | 7.790ms | 29.190ms |
| PdfDoc (Level 2) | 3.671ms | 6.440ms | — |

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
| Pdf (Level 3) | 5.452ms | 7.233ms | 25.940ms |
| PdfDoc (Level 2) | 2.010ms | 34.074ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 3.392ms | 958.000μs | 3.355ms |
| smalot/pdfparser | 1.312ms | 1.562ms | 3.731ms |
| setasign/fpdi | 1.225ms | 1.700ms | 18.868ms |

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
| phpdftk | 1.182ms | 802.706μs |
| smalot/pdfparser | FAIL | 1.257ms |
| setasign/fpdi | 1.811ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 6.777ms   | ±2.43%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 6.663ms   | ±1.93%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 7.771ms   | ±2.68%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 7.637ms   | ±1.22%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 7.002ms   | ±0.56%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 6.682ms   | ±0.73%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 11.982ms  | ±0.96%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 1.906ms   | ±1.09%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 5.452ms   | ±85.13%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 7.233ms   | ±24.75%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 25.940ms  | ±19.89%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 2.010ms   | ±3.93%   |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 34.074ms  | ±67.77%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 0.649μs   | ±43.51%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 0.786μs   | ±54.55%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.245mb | 10.454ms  | ±1.36%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.245mb | 10.395ms  | ±1.06%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.048mb | 31.423ms  | ±2.65%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.639mb | 63.083ms  | ±5.92%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.290mb | 737.365ms | ±1.24%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.211mb | 19.182ms  | ±43.34%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.237mb | 35.932ms  | ±16.24%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.048mb | 299.586ms | ±0.22%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.494mb | 44.558ms  | ±48.04%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.214mb | 55.002ms  | ±22.23%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.983mb | 498.398ms | ±0.97%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.259mb | 15.638ms  | ±53.10%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.259mb | 39.749ms  | ±48.61%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.901mb | 196.616ms | ±9.63%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 2.924ms   | ±134.51% |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 7.790ms   | ±2.27%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 29.190ms  | ±13.44%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.671ms   | ±107.79% |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 6.440ms   | ±11.68%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 745.708μs | ±2.25%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 958.000μs | ±2.03%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 3.355ms   | ±0.29%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 1.182ms   | ±1.20%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 802.706μs | ±1.50%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.312ms   | ±1.90%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 1.562ms   | ±3.24%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 3.731ms   | ±0.72%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 371.453μs | ±2.55%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.257ms   | ±1.49%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.225ms   | ±0.83%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 1.700ms   | ±5.40%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 18.868ms  | ±4.21%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 1.811ms   | ±0.41%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 976.114μs | ±2.15%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 4.337ms   | ±0.51%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 3.322ms   | ±1.67%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 2.397ms   | ±0.21%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 1.576μs   | ±28.12%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 3.392ms   | ±1.01%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.472mb  | 13.991ms  | ±0.18%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.480mb | 124.787ms | ±0.38%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.098mb | 632.171ms | ±3.41%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 1.571ms   | ±2.74%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 1.948ms   | ±47.41%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 4.520ms   | ±57.54%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 1.760ms   | ±6.45%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 2.003ms   | ±7.89%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 4.985ms   | ±1.13%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 2.222ms   | ±148.32% |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 3.015ms   | ±109.78% |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 8.212ms   | ±25.35%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 5.221ms   | ±126.57% |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 1.918ms   | ±105.29% |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 4.810ms   | ±132.92% |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.942ms   | ±95.02%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 4.573ms   | ±1.00%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.148ms   | ±79.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 2.589ms   | ±28.07%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 7.920ms   | ±85.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 2.400ms   | ±98.17%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 1.885ms   | ±92.36%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 26.652ms  | ±86.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 8.073ms   | ±102.02% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 2.518ms   | ±131.53% |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 2.174ms   | ±76.13%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 136.474ms | ±20.20%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 2.922ms   | ±61.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 11.528ms  | ±93.25%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.978ms   | ±67.61%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 7.350ms   | ±50.17%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 8.285ms   | ±24.62%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 14.550ms  | ±112.64% |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 14.194ms  | ±13.61%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 20.572ms  | ±0.31%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 1.141ms   | ±108.81% |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 2.385ms   | ±141.16% |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 665.997μs | ±52.41%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 4.594ms   | ±151.31% |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.138ms   | ±98.88%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 19.126ms  | ±27.25%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 21.110ms  | ±23.35%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 22.417ms  | ±21.62%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 39.895ms  | ±0.58%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 62.023ms  | ±28.84%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 8.221ms   | ±32.17%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 10.363ms  | ±47.90%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 14.641ms  | ±40.73%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 43.181ms  | ±0.34%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 96.680ms  | ±0.21%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 4.340ms   | ±88.19%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 30.371ms  | ±0.31%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 0.334μs   | ±33.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 0.335μs   | ±57.14%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 0.999μs   | ±30.77%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 132.129ms | ±12.02%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 275.718μs | ±3.71%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 1.920ms   | ±1.11%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.283ms   | ±134.82% |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 21.470ms  | ±26.48%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 47.632ms  | ±0.45%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 8.221ms   | ±0.24%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 14.464ms  | ±0.68%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 126.888ms | ±13.32%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 11.773ms  | ±70.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 18.252ms  | ±33.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 8.748ms   | ±28.74%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 9.163ms   | ±64.86%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 8.841ms   | ±0.59%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 2.167ms   | ±74.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 8.613ms   | ±0.85%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 8.756ms   | ±48.20%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 8.749ms   | ±70.40%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.988ms   | ±117.10% |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 27.006ms  | ±82.08%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 2.819ms   | ±2.49%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 3.769ms   | ±5.98%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 7.399ms   | ±93.22%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 13.600ms  | ±58.77%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 15.411ms  | ±77.34%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 15.469ms  | ±55.68%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 19.175ms  | ±1.42%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 27.384ms  | ±1.08%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 792.330μs | ±4.06%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 4.484ms   | ±136.04% |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 917.786μs | ±3.46%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.346ms   | ±1.71%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 1.923ms   | ±1.94%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 24.050μs  | ±2.98%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 151.945μs | ±1.81%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.338mb | 46.039ms  | ±0.26%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.169mb | 195.986ms | ±0.23%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.832mb | 829.084ms | ±4.94%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.400mb | 158.634ms | ±5.95%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.956mb | 110.927ms | ±0.47%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.123mb | 86.518ms  | ±0.32%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.174mb | 116.561ms | ±0.15%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.723mb | 108.348ms | ±5.29%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.218mb | 181.915ms | ±0.14%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.862mb | 28.688ms  | ±0.36%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.781mb | 25.221ms  | ±0.20%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.710mb | 23.972ms  | ±0.69%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.011mb | 76.836ms  | ±0.46%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.770mb | 26.428ms  | ±0.72%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.982mb | 32.999ms  | ±0.20%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.398mb | 48.795ms  | ±6.41%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.677mb | 22.218ms  | ±6.13%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.614mb | 26.288ms  | ±0.39%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.642mb | 27.294ms  | ±0.26%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.611mb | 26.570ms  | ±0.35%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.633mb | 25.712ms  | ±0.54%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.596mb | 42.329ms  | ±0.16%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.649mb | 25.763ms  | ±0.33%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.326mb | 22.777ms  | ±0.46%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.579mb | 24.386ms  | ±0.51%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.600mb | 27.308ms  | ±0.36%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.593mb | 27.175ms  | ±0.16%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.817mb | 25.130ms  | ±1.81%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.965mb | 122.377ms | ±2.61%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.242mb | 99.041ms  | ±5.59%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 6.314ms   | ±30.11%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 6.121ms   | ±36.95%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 6.134ms   | ±80.05%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```