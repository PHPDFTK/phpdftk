# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-29 05:19:23 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 11.845ms | 2.384ms | 2.565ms | 4.933ms | 6.722ms |
| FPDF | 920.708μs | 917.730μs | 1.026ms | 1.591ms | 2.390ms |
| TCPDF | 10.445ms | 11.271ms | 12.152ms | 19.772ms | 29.403ms |
| mPDF | 25.351ms | 28.503ms | 31.826ms | 57.387ms | 88.929ms |
| Dompdf | 11.135ms | 17.913ms | 19.626ms | 61.617ms | 135.560ms |

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
| phpdftk | 3.110ms | 3.353ms | 3.560ms | 5.500ms | 8.070ms |
| FPDF | 1.141ms | 1.204ms | 1.304ms | 2.033ms | 2.891ms |
| TCPDF | 17.358ms | 18.225ms | 19.115ms | 27.639ms | 38.690ms |

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
| Pdf (Level 3) | 3.161ms | 4.310ms | 11.245ms |
| PdfDoc (Level 2) | 2.532ms | 3.024ms | 7.213ms |
| PdfWriter (Level 1) | 2.346ms | 2.617ms | 6.564ms |

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
| Pdf (Level 3) | 4.181ms | 10.957ms | 40.927ms |
| PdfDoc (Level 2) | 3.595ms | 9.280ms | — |

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
| Pdf (Level 3) | 3.746ms | 10.170ms | 37.269ms |
| PdfDoc (Level 2) | 3.063ms | 6.634ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 4.954ms | 1.421ms | 4.824ms |
| smalot/pdfparser | 1.933ms | 2.247ms | 5.300ms |
| setasign/fpdi | 1.779ms | 2.452ms | 23.658ms |

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
| phpdftk | 1.704ms | 1.198ms |
| smalot/pdfparser | FAIL | 1.806ms |
| setasign/fpdi | 2.612ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 9.672ms   | ±0.74%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 9.799ms   | ±0.56%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 10.931ms  | ±1.01%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 11.156ms  | ±0.54%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 10.169ms  | ±0.49%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 9.774ms   | ±0.96%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 17.405ms  | ±0.30%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 2.811ms   | ±0.44%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 3.746ms   | ±0.80%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 10.170ms  | ±0.71%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 37.269ms  | ±0.75%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.063ms   | ±0.93%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 6.634ms   | ±10.94% |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.061μs   | ±35.36% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.321μs   | ±50.51% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.233mb | 15.009ms  | ±0.86%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.233mb | 14.762ms  | ±0.53%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.036mb | 45.654ms  | ±0.06%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.627mb | 90.241ms  | ±0.19%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.278mb | 1.067s    | ±0.22%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.199mb | 23.700ms  | ±2.47%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.225mb | 50.895ms  | ±0.37%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.036mb | 449.042ms | ±0.15%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.482mb | 58.721ms  | ±9.53%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.202mb | 83.105ms  | ±7.79%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.971mb | 643.679ms | ±0.58%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.247mb | 56.220ms  | ±12.89% |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.247mb | 39.565ms  | ±0.52%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.889mb | 275.241ms | ±0.23%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.181ms   | ±0.64%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 10.957ms  | ±1.03%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 40.927ms  | ±0.24%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.595ms   | ±0.94%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 9.280ms   | ±13.58% |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.070ms   | ±1.35%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.421ms   | ±2.37%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 4.824ms   | ±0.53%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 1.704ms   | ±0.67%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.198ms   | ±1.34%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.933ms   | ±1.55%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.247ms   | ±1.49%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.300ms   | ±1.14%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 553.925μs | ±0.30%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.806ms   | ±2.07%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.779ms   | ±0.61%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.452ms   | ±0.26%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 23.658ms  | ±0.13%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.612ms   | ±0.46%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.424ms   | ±0.28%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 6.255ms   | ±0.33%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 4.859ms   | ±0.42%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.511ms   | ±0.47%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 2.619μs   | ±28.70% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 4.954ms   | ±1.04%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 20.337ms  | ±0.36%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 181.526ms | ±0.39%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 899.697ms | ±0.11%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.346ms   | ±34.16% |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.617ms   | ±1.01%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.564ms   | ±0.60%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.532ms   | ±3.02%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.024ms   | ±1.25%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.213ms   | ±0.57%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.161ms   | ±12.34% |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.310ms   | ±42.10% |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 11.245ms  | ±11.02% |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.164ms   | ±2.45%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.384ms   | ±1.15%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.565ms   | ±0.45%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.933ms   | ±30.65% |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 6.722ms   | ±0.58%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.453ms   | ±34.94% |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.664ms   | ±0.65%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 11.340ms  | ±25.02% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.453ms   | ±0.79%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.268ms   | ±0.60%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 619.097μs | ±27.36% |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.125ms   | ±2.17%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.506ms   | ±1.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.068ms   | ±0.80%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 205.944ms | ±8.67%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.676ms   | ±46.19% |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.905ms   | ±33.03% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 5.616ms   | ±1.61%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.445ms  | ±0.78%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.271ms  | ±17.91% |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.152ms  | ±0.57%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 19.772ms  | ±5.18%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 29.403ms  | ±0.38%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 920.708μs | ±46.74% |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 917.730μs | ±87.11% |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 1.026ms   | ±79.51% |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.591ms   | ±60.48% |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.390ms   | ±6.60%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.351ms  | ±1.87%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.503ms  | ±0.47%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 31.826ms  | ±0.45%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 57.387ms  | ±0.33%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 88.929ms  | ±0.57%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.135ms  | ±2.36%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 17.913ms  | ±9.25%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 19.626ms  | ±0.80%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 61.617ms  | ±0.43%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 135.560ms | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 4.722ms   | ±0.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 41.752ms  | ±0.17%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.483μs   | ±30.69% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.333μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.333μs   | ±15.81% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 225.743ms | ±26.63% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 395.214μs | ±5.23%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.707ms   | ±0.86%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.297ms   | ±1.27%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 10.148ms  | ±33.14% |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 68.844ms  | ±0.38%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 11.800ms  | ±0.19%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 20.767ms  | ±0.41%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 186.545ms | ±18.89% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 11.852ms  | ±0.48%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 11.930ms  | ±0.67%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 11.971ms  | ±0.35%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 12.025ms  | ±0.37%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 12.323ms  | ±0.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.108ms   | ±0.83%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 12.033ms  | ±0.65%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 11.926ms  | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 11.845ms  | ±0.54%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.110ms   | ±0.50%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.353ms   | ±1.07%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.560ms   | ±0.73%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.500ms   | ±0.58%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.070ms   | ±1.70%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.358ms  | ±0.79%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.225ms  | ±0.26%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.115ms  | ±0.56%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 27.639ms  | ±0.53%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 38.690ms  | ±2.43%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.141ms   | ±1.87%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.204ms   | ±7.88%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.304ms   | ±1.61%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 2.033ms   | ±2.52%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.891ms   | ±1.61%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 34.855μs  | ±0.32%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 214.713μs | ±0.75%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.326mb | 66.622ms  | ±0.15%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.157mb | 283.917ms | ±0.11%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.820mb | 1.111s    | ±0.10%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.388mb | 199.516ms | ±0.16%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.944mb | 153.495ms | ±0.06%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.111mb | 124.554ms | ±0.15%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.162mb | 168.577ms | ±0.25%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.711mb | 140.352ms | ±0.09%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.206mb | 263.588ms | ±0.15%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.850mb | 41.644ms  | ±0.15%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.769mb | 36.539ms  | ±0.37%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.698mb | 34.900ms  | ±0.56%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.934mb | 110.942ms | ±0.29%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.758mb | 38.407ms  | ±0.59%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.970mb | 47.715ms  | ±0.30%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.386mb | 70.042ms  | ±0.09%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.665mb | 31.217ms  | ±0.52%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.602mb | 37.829ms  | ±0.33%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.630mb | 39.236ms  | ±0.33%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.598mb | 38.231ms  | ±0.52%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.621mb | 37.213ms  | ±0.31%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.584mb | 60.518ms  | ±0.91%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.637mb | 36.736ms  | ±0.50%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.314mb | 32.764ms  | ±0.20%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.567mb | 35.038ms  | ±0.54%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.588mb | 39.280ms  | ±0.53%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.581mb | 38.947ms  | ±0.28%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.805mb | 36.221ms  | ±0.34%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.953mb | 176.989ms | ±0.05%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.230mb | 136.196ms | ±0.44%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 7.840ms   | ±0.46%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 7.471ms   | ±0.69%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 7.555ms   | ±0.71%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```