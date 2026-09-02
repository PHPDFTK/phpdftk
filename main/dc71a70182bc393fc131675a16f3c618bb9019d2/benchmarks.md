# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-02 02:10:12 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.298ms | 2.519ms | 2.748ms | 4.816ms | 7.030ms |
| FPDF | 785.694μs | 824.479μs | 912.571μs | 1.523ms | 2.269ms |
| TCPDF | 9.932ms | 10.948ms | 11.962ms | 20.504ms | 31.323ms |
| mPDF | 25.055ms | 29.034ms | 33.066ms | 64.885ms | 105.541ms |
| Dompdf | 11.193ms | 15.836ms | 21.282ms | 73.477ms | 162.092ms |

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
| phpdftk | 3.291ms | 3.546ms | 3.818ms | 5.965ms | 8.512ms |
| FPDF | 1.038ms | 1.118ms | 1.195ms | 1.911ms | 2.748ms |
| TCPDF | 17.421ms | 18.016ms | 19.403ms | 29.220ms | 41.656ms |

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
| Pdf (Level 3) | 3.364ms | 4.431ms | 12.585ms |
| PdfDoc (Level 2) | 2.709ms | 3.155ms | 7.551ms |
| PdfWriter (Level 1) | 2.310ms | 2.737ms | 6.915ms |

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
| Pdf (Level 3) | 4.348ms | 12.018ms | 46.454ms |
| PdfDoc (Level 2) | 3.729ms | 9.933ms | — |

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
| Pdf (Level 3) | 4.057ms | 11.629ms | 46.081ms |
| PdfDoc (Level 2) | 3.306ms | 7.313ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.157ms | 1.672ms | 5.932ms |
| smalot/pdfparser | 1.985ms | 2.358ms | 5.792ms |
| setasign/fpdi | 1.908ms | 2.834ms | 29.782ms |

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
| phpdftk | 2.019ms | 1.357ms |
| smalot/pdfparser | FAIL | 1.910ms |
| setasign/fpdi | 2.968ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 10.243ms  | ±0.29%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 10.663ms  | ±13.72% |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 11.829ms  | ±3.33%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 12.061ms  | ±1.17%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 11.010ms  | ±0.13%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 10.229ms  | ±1.11%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 19.361ms  | ±0.79%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 2.992ms   | ±1.05%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.057ms   | ±0.71%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.629ms  | ±9.14%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 46.081ms  | ±8.00%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.306ms   | ±0.94%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.313ms   | ±0.51%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.049μs   | ±16.64% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.997μs   | ±29.66% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.235mb | 16.121ms  | ±0.69%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.235mb | 16.016ms  | ±0.32%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.038mb | 56.009ms  | ±0.87%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.629mb | 113.776ms | ±0.22%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.280mb | 1.375s    | ±1.44%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.201mb | 25.990ms  | ±3.03%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.227mb | 58.389ms  | ±0.83%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.038mb | 530.949ms | ±0.59%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.484mb | 64.104ms  | ±9.73%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.204mb | 90.514ms  | ±24.91% |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.973mb | 731.069ms | ±0.22%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.249mb | 18.654ms  | ±1.58%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.249mb | 43.175ms  | ±0.47%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.892mb | 320.515ms | ±0.67%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.348ms   | ±1.01%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.018ms  | ±0.83%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 46.454ms  | ±0.41%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.729ms   | ±0.50%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 9.933ms   | ±0.58%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.221ms   | ±0.72%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.672ms   | ±0.74%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.932ms   | ±0.41%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.019ms   | ±4.50%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.357ms   | ±0.42%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.985ms   | ±1.27%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.358ms   | ±0.68%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.792ms   | ±0.50%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 547.710μs | ±1.68%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.910ms   | ±0.87%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.908ms   | ±1.57%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.834ms   | ±0.37%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.782ms  | ±0.95%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.968ms   | ±0.92%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.515ms   | ±0.75%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.312ms   | ±0.72%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.429ms   | ±0.96%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.895ms   | ±0.68%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.408μs   | ±20.83% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.157ms   | ±0.68%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 26.265ms  | ±0.41%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 235.332ms | ±0.72%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 1.164s    | ±0.98%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.310ms   | ±0.22%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.737ms   | ±1.49%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.915ms   | ±0.79%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.709ms   | ±0.81%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.155ms   | ±1.82%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.551ms   | ±0.86%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.364ms   | ±1.04%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.431ms   | ±0.84%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.585ms  | ±0.30%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.302ms   | ±0.37%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.519ms   | ±2.24%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.748ms   | ±0.79%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.816ms   | ±0.80%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.030ms   | ±0.46%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.584ms   | ±0.64%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.842ms   | ±28.28% |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.436ms  | ±39.50% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.619ms   | ±0.68%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.374ms   | ±1.04%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 669.611μs | ±3.22%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.203ms   | ±0.80%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.660ms   | ±0.73%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.235ms   | ±4.79%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 202.200ms | ±17.12% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.560ms   | ±0.88%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.829ms   | ±84.61% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.054ms   | ±0.83%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.932ms   | ±1.38%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.948ms  | ±2.03%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.962ms  | ±0.52%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.504ms  | ±2.26%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.323ms  | ±0.59%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 785.694μs | ±2.40%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 824.479μs | ±1.64%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 912.571μs | ±0.79%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.523ms   | ±1.85%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.269ms   | ±0.69%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.055ms  | ±2.00%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.034ms  | ±0.39%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.066ms  | ±0.45%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 64.885ms  | ±0.38%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 105.541ms | ±0.39%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.193ms  | ±0.41%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.836ms  | ±0.46%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.282ms  | ±0.64%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 73.477ms  | ±0.82%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 162.092ms | ±0.48%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.070ms   | ±0.99%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 49.572ms  | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.665μs   | ±17.39% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.624μs   | ±18.18% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 142.236ms | ±40.59% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 453.922μs | ±0.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.007ms   | ±0.17%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.403ms   | ±0.81%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 13.867ms  | ±5.47%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 85.658ms  | ±1.63%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.329ms  | ±0.26%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.068ms  | ±1.04%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 182.408ms | ±19.94% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.373ms  | ±0.78%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.354ms  | ±0.88%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.464ms  | ±0.35%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.562ms  | ±2.27%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 13.866ms  | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.143ms   | ±1.23%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.473ms  | ±0.71%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.389ms  | ±0.53%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.298ms  | ±0.88%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.291ms   | ±1.45%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.546ms   | ±0.55%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.818ms   | ±0.92%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.965ms   | ±1.24%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.512ms   | ±0.91%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.421ms  | ±1.24%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.016ms  | ±0.19%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.403ms  | ±1.21%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.220ms  | ±0.30%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.656ms  | ±1.43%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.038ms   | ±2.55%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.118ms   | ±2.68%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.195ms   | ±1.94%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.911ms   | ±1.52%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.748ms   | ±0.79%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.514μs  | ±0.65%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 241.942μs | ±0.42%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.328mb | 84.557ms  | ±0.99%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.159mb | 365.551ms | ±0.61%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.822mb | 1.437s    | ±0.57%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.390mb | 256.247ms | ±0.40%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.946mb | 195.654ms | ±0.37%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.113mb | 159.440ms | ±0.16%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.164mb | 217.021ms | ±0.76%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.713mb | 178.696ms | ±0.20%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.208mb | 338.773ms | ±0.15%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.852mb | 51.506ms  | ±0.16%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.771mb | 44.953ms  | ±1.21%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.700mb | 42.028ms  | ±0.65%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.936mb | 139.089ms | ±0.51%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.760mb | 46.908ms  | ±0.92%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.972mb | 59.410ms  | ±0.14%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.388mb | 89.297ms  | ±1.53%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.667mb | 37.754ms  | ±0.45%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.604mb | 45.794ms  | ±0.16%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.632mb | 47.497ms  | ±0.48%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.601mb | 46.443ms  | ±0.31%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.623mb | 45.562ms  | ±0.59%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.587mb | 71.554ms  | ±0.91%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.640mb | 43.376ms  | ±0.46%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.316mb | 39.135ms  | ±0.14%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.569mb | 42.481ms  | ±0.16%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.590mb | 47.888ms  | ±1.02%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.583mb | 47.304ms  | ±0.31%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.807mb | 42.351ms  | ±0.66%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.955mb | 224.423ms | ±0.14%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.233mb | 169.245ms | ±0.27%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 8.991ms   | ±0.82%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.470ms   | ±0.38%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.531ms   | ±1.17%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```