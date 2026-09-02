# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-02 05:11:52 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.997ms | 2.536ms | 2.776ms | 4.824ms | 7.095ms |
| FPDF | 767.279μs | 817.076μs | 933.905μs | 1.526ms | 2.248ms |
| TCPDF | 9.969ms | 10.936ms | 11.996ms | 20.513ms | 31.177ms |
| mPDF | 25.075ms | 28.969ms | 33.109ms | 66.660ms | 106.756ms |
| Dompdf | 11.634ms | 16.452ms | 22.102ms | 73.594ms | 163.899ms |

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
| phpdftk | 3.585ms | 3.804ms | 4.038ms | 6.084ms | 8.740ms |
| FPDF | 1.122ms | 1.187ms | 1.291ms | 1.991ms | 2.748ms |
| TCPDF | 19.189ms | 20.038ms | 21.333ms | 31.489ms | 43.047ms |

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
| Pdf (Level 3) | 3.426ms | 4.460ms | 12.831ms |
| PdfDoc (Level 2) | 2.717ms | 3.205ms | 7.624ms |
| PdfWriter (Level 1) | 2.326ms | 2.806ms | 6.983ms |

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
| Pdf (Level 3) | 4.382ms | 12.353ms | 47.111ms |
| PdfDoc (Level 2) | 3.962ms | 10.124ms | — |

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
| Pdf (Level 3) | 4.042ms | 11.714ms | 45.187ms |
| PdfDoc (Level 2) | 3.285ms | 7.511ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.219ms | 1.664ms | 6.022ms |
| smalot/pdfparser | 1.984ms | 2.356ms | 5.739ms |
| setasign/fpdi | 1.939ms | 2.828ms | 30.129ms |

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
| phpdftk | 2.015ms | 1.365ms |
| smalot/pdfparser | FAIL | 1.918ms |
| setasign/fpdi | 2.986ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 10.450ms  | ±0.48%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 10.515ms  | ±0.12%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 12.105ms  | ±1.01%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 12.111ms  | ±0.63%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 11.114ms  | ±0.17%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 10.335ms  | ±0.30%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 19.338ms  | ±0.22%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 3.013ms   | ±0.14%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.042ms   | ±0.90%   |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.714ms  | ±0.61%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.187ms  | ±0.40%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.285ms   | ±1.59%   |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.511ms   | ±0.81%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.061μs   | ±20.20%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.097μs   | ±29.77%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.248mb | 16.848ms  | ±1.45%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.248mb | 16.155ms  | ±1.10%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.051mb | 55.635ms  | ±6.41%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.642mb | 114.029ms | ±0.52%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.293mb | 1.380s    | ±1.26%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.213mb | 25.952ms  | ±2.35%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.240mb | 58.048ms  | ±0.63%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.051mb | 523.272ms | ±1.74%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.497mb | 64.251ms  | ±8.79%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.216mb | 86.273ms  | ±1.32%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.985mb | 732.108ms | ±0.63%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.262mb | 18.695ms  | ±0.14%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.262mb | 43.167ms  | ±0.37%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.904mb | 320.985ms | ±0.31%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.382ms   | ±1.09%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.353ms  | ±0.87%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.111ms  | ±2.03%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.962ms   | ±149.74% |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.124ms  | ±0.63%   |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.249ms   | ±1.16%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.664ms   | ±0.19%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.022ms   | ±0.49%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.015ms   | ±0.92%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.365ms   | ±0.52%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.984ms   | ±0.99%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.356ms   | ±0.83%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.739ms   | ±0.24%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 553.059μs | ±1.58%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.918ms   | ±0.65%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.939ms   | ±2.34%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.828ms   | ±0.37%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 30.129ms  | ±1.44%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.986ms   | ±0.32%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.507ms   | ±0.47%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.289ms   | ±0.53%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.441ms   | ±0.40%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.843ms   | ±0.51%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.297μs   | ±20.20%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.219ms   | ±0.53%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.472mb  | 26.166ms  | ±0.66%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.480mb | 232.716ms | ±0.85%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.098mb | 1.163s    | ±0.15%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.326ms   | ±3.72%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.806ms   | ±0.95%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.983ms   | ±0.80%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.717ms   | ±1.48%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.205ms   | ±0.88%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.624ms   | ±0.86%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.426ms   | ±1.42%   |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.460ms   | ±1.24%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.831ms  | ±0.36%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.295ms   | ±0.68%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.536ms   | ±1.32%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.776ms   | ±0.85%   |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.824ms   | ±0.49%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.095ms   | ±1.24%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.574ms   | ±0.83%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.837ms   | ±0.67%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.196ms  | ±9.88%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.632ms   | ±1.36%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.371ms   | ±1.16%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 615.858μs | ±7.08%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.193ms   | ±0.93%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.634ms   | ±0.88%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.245ms   | ±0.65%   |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 175.658ms | ±20.22%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.588ms   | ±0.56%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.817ms   | ±23.20%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.058ms   | ±0.87%   |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.969ms   | ±0.49%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.936ms  | ±0.76%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.996ms  | ±1.08%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.513ms  | ±0.42%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.177ms  | ±0.63%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 767.279μs | ±1.84%   |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 817.076μs | ±0.87%   |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 933.905μs | ±1.88%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.526ms   | ±1.65%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.248ms   | ±0.88%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.075ms  | ±1.64%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.969ms  | ±0.43%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.109ms  | ±0.85%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 66.660ms  | ±0.44%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 106.756ms | ±0.52%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.634ms  | ±1.78%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.452ms  | ±0.37%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 22.102ms  | ±7.10%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 73.594ms  | ±0.73%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 163.899ms | ±0.87%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.285ms   | ±17.35%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.638ms  | ±1.03%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 174.772ms | ±22.41%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 461.574μs | ±1.79%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.996ms   | ±1.12%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.391ms   | ±0.77%   |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 14.177ms  | ±3.33%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 85.283ms  | ±0.77%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.424ms  | ±0.74%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.293ms  | ±0.60%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 179.502ms | ±37.37%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 14.185ms  | ±0.98%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 14.430ms  | ±0.50%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 14.185ms  | ±0.76%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 14.532ms  | ±1.15%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.761ms  | ±1.61%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.567ms   | ±1.12%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 14.483ms  | ±1.32%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 14.492ms  | ±0.97%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.997ms  | ±1.09%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.585ms   | ±0.98%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.804ms   | ±0.81%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 4.038ms   | ±1.41%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 6.084ms   | ±0.59%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.740ms   | ±1.97%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 19.189ms  | ±0.16%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 20.038ms  | ±1.10%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 21.333ms  | ±0.96%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 31.489ms  | ±0.53%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 43.047ms  | ±1.95%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.122ms   | ±0.08%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.187ms   | ±0.95%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.291ms   | ±1.64%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.991ms   | ±2.76%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.748ms   | ±0.54%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.531μs  | ±0.81%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 245.869μs | ±0.68%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.341mb | 85.055ms  | ±0.70%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.172mb | 371.445ms | ±0.87%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.835mb | 1.452s    | ±0.77%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.402mb | 257.309ms | ±1.09%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.959mb | 203.430ms | ±0.73%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.126mb | 163.902ms | ±0.45%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.177mb | 221.380ms | ±0.62%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.725mb | 183.968ms | ±1.22%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.221mb | 342.906ms | ±0.52%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.865mb | 52.093ms  | ±0.58%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.784mb | 45.124ms  | ±0.49%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.713mb | 42.712ms  | ±1.08%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.014mb | 143.908ms | ±0.11%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.773mb | 49.923ms  | ±3.73%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.984mb | 61.439ms  | ±0.98%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.401mb | 91.083ms  | ±1.88%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.680mb | 37.891ms  | ±0.76%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.617mb | 46.078ms  | ±0.54%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.645mb | 47.915ms  | ±1.10%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.613mb | 46.566ms  | ±0.31%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.635mb | 45.359ms  | ±0.14%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.599mb | 70.937ms  | ±0.67%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.652mb | 43.661ms  | ±0.47%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.329mb | 39.419ms  | ±1.11%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.582mb | 42.963ms  | ±1.05%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.603mb | 47.811ms  | ±1.70%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.596mb | 50.069ms  | ±0.35%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.820mb | 45.076ms  | ±0.45%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.968mb | 228.756ms | ±0.59%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.245mb | 171.365ms | ±0.39%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.112ms   | ±6.36%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.582ms   | ±1.63%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.607ms   | ±1.50%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```