# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-26 18:57:27 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.301ms | 2.508ms | 2.739ms | 4.743ms | 7.073ms |
| FPDF | 817.245μs | 865.204μs | 946.920μs | 1.513ms | 2.268ms |
| TCPDF | 9.917ms | 10.874ms | 12.064ms | 20.884ms | 31.434ms |
| mPDF | 25.485ms | 29.221ms | 32.978ms | 65.289ms | 103.096ms |
| Dompdf | 11.250ms | 15.938ms | 21.502ms | 72.927ms | 160.075ms |

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
| phpdftk | 3.282ms | 3.536ms | 3.866ms | 5.791ms | 8.314ms |
| FPDF | 1.045ms | 1.162ms | 1.228ms | 1.901ms | 2.768ms |
| TCPDF | 17.149ms | 18.585ms | 19.533ms | 29.514ms | 41.582ms |

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
| Pdf (Level 3) | 3.327ms | 4.505ms | 12.911ms |
| PdfDoc (Level 2) | 2.776ms | 3.196ms | 7.721ms |
| PdfWriter (Level 1) | 2.286ms | 2.763ms | 6.868ms |

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
| Pdf (Level 3) | 4.327ms | 12.221ms | 46.799ms |
| PdfDoc (Level 2) | 3.745ms | 9.954ms | — |

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
| Pdf (Level 3) | 4.057ms | 11.650ms | 45.163ms |
| PdfDoc (Level 2) | 3.261ms | 7.277ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.228ms | 1.668ms | 5.953ms |
| smalot/pdfparser | 2.011ms | 2.370ms | 5.726ms |
| setasign/fpdi | 1.919ms | 2.862ms | 29.992ms |

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
| phpdftk | 2.006ms | 1.348ms |
| smalot/pdfparser | FAIL | 1.906ms |
| setasign/fpdi | 3.028ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.265mb  | 10.571ms  | ±1.53%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.159mb  | 10.387ms  | ±5.91%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.982mb  | 11.858ms  | ±0.87%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.007mb  | 11.965ms  | ±0.28%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.426mb  | 11.064ms  | ±2.96%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.563mb  | 10.264ms  | ±0.22%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.808mb | 19.363ms  | ±0.49%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 3.011ms   | ±0.50%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.057ms   | ±7.96%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.650ms  | ±0.44%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.163ms  | ±0.27%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.261ms   | ±1.04%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.277ms   | ±7.64%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.766μs   | ±21.60% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.061μs   | ±20.20% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 14.687mb | 15.512ms  | ±0.64%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 14.687mb | 15.535ms  | ±0.48%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 15.490mb | 54.684ms  | ±7.07%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.080mb | 110.440ms | ±0.24%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.010mb | 1.344s    | ±0.12%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.138mb | 25.722ms  | ±3.27%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.164mb | 58.281ms  | ±0.19%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.975mb | 540.690ms | ±0.37%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.422mb | 63.128ms  | ±9.47%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.141mb | 85.487ms  | ±0.84%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.844mb | 732.315ms | ±0.41%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.186mb | 19.263ms  | ±0.94%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.186mb | 43.489ms  | ±0.91%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.829mb | 324.496ms | ±1.30%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.327ms   | ±5.90%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.221ms  | ±0.74%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 46.799ms  | ±0.49%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.745ms   | ±1.24%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 9.954ms   | ±3.80%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.231ms   | ±0.89%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.668ms   | ±0.96%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.953ms   | ±0.43%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.006ms   | ±0.66%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.348ms   | ±1.74%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.011ms   | ±1.08%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.370ms   | ±0.98%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.726ms   | ±1.02%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 555.094μs | ±0.83%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.906ms   | ±0.47%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.919ms   | ±1.27%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.862ms   | ±1.82%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.992ms  | ±1.03%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.028ms   | ±1.14%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.545ms   | ±2.05%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.339ms   | ±1.32%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.520ms   | ±0.73%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.878ms   | ±1.59%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.915μs   | ±14.02% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.228ms   | ±0.42%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.426mb  | 25.945ms  | ±0.91%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.434mb | 228.434ms | ±0.96%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.052mb | 1.131s    | ±0.52%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.286ms   | ±1.70%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.763ms   | ±0.74%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.868ms   | ±1.89%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.776ms   | ±8.77%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.196ms   | ±0.64%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.721ms   | ±1.15%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.327ms   | ±2.81%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.505ms   | ±0.77%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.911ms  | ±4.00%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.351ms   | ±1.51%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.508ms   | ±0.90%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.739ms   | ±0.94%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.743ms   | ±1.92%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.073ms   | ±1.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.604ms   | ±8.27%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.885ms   | ±0.71%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.373ms  | ±0.99%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.658ms   | ±0.78%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.366ms   | ±1.00%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 660.132μs | ±3.41%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.171ms   | ±10.31% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.641ms   | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.217ms   | ±0.50%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 191.707ms | ±25.57% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.563ms   | ±0.96%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.779ms   | ±1.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 5.993ms   | ±0.75%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.917ms   | ±0.36%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.874ms  | ±3.71%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.064ms  | ±0.93%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.884ms  | ±2.31%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.434ms  | ±1.63%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 817.245μs | ±2.89%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 865.204μs | ±2.30%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 946.920μs | ±1.49%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.513ms   | ±21.84% |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.268ms   | ±1.55%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.485ms  | ±1.89%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.221ms  | ±2.09%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.978ms  | ±0.42%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.289ms  | ±0.78%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 103.096ms | ±0.77%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.250ms  | ±0.23%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.938ms  | ±0.86%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.502ms  | ±1.19%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 72.927ms  | ±0.42%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 160.075ms | ±0.93%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.158ms   | ±4.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.630ms  | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 205.809ms | ±16.12% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 461.984μs | ±1.04%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.985ms   | ±0.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.410ms   | ±0.97%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 12.234ms  | ±3.84%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 88.882ms  | ±0.95%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.633ms  | ±12.34% |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 24.999ms  | ±7.03%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 237.152ms | ±23.87% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.462ms  | ±0.17%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.421ms  | ±0.56%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.472ms  | ±0.32%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.469ms  | ±0.83%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 13.874ms  | ±3.55%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.135ms   | ±4.08%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.584ms  | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.489ms  | ±0.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.301ms  | ±0.66%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.282ms   | ±0.40%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.536ms   | ±1.33%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.866ms   | ±2.49%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.791ms   | ±1.03%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.314ms   | ±0.34%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.149ms  | ±0.46%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.585ms  | ±0.67%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.533ms  | ±0.66%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.514ms  | ±0.98%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.582ms  | ±1.32%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.045ms   | ±2.53%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.162ms   | ±1.96%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.228ms   | ±1.32%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.901ms   | ±0.84%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.768ms   | ±4.30%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.406μs  | ±1.19%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 244.701μs | ±0.72%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 15.780mb | 82.463ms  | ±2.36%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.889mb | 357.912ms | ±0.69%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.552mb | 1.389s    | ±0.67%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.079mb | 247.589ms | ±0.22%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.663mb | 191.615ms | ±0.41%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 16.499mb | 154.394ms | ±0.54%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 17.550mb | 213.637ms | ±1.55%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.164mb | 175.488ms | ±0.75%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 19.659mb | 327.360ms | ±0.37%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.238mb | 50.680ms  | ±0.65%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.157mb | 44.186ms  | ±0.48%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.152mb | 41.809ms  | ±0.99%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.387mb | 136.937ms | ±0.96%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.146mb | 45.953ms  | ±0.90%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.358mb | 58.326ms  | ±1.34%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 15.774mb | 86.578ms  | ±0.82%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.053mb | 37.591ms  | ±1.08%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.056mb | 45.697ms  | ±0.31%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.083mb | 47.015ms  | ±0.67%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.052mb | 45.744ms  | ±0.99%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.074mb | 44.189ms  | ±1.31%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.316mb | 70.571ms  | ±0.63%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.369mb | 42.984ms  | ±0.07%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.046mb | 38.032ms  | ±0.74%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.021mb | 41.795ms  | ±1.11%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.041mb | 46.783ms  | ±0.78%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.035mb | 45.967ms  | ±0.13%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.537mb | 41.920ms  | ±0.91%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.407mb | 219.302ms | ±0.50%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 15.618mb | 167.878ms | ±1.08%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 8.911ms   | ±0.56%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.530ms   | ±6.94%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.641ms   | ±1.47%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```