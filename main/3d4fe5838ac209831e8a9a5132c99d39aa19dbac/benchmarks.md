# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-27 01:33:07 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.221ms | 2.492ms | 2.734ms | 4.749ms | 7.008ms |
| FPDF | 751.149μs | 821.830μs | 932.378μs | 1.518ms | 2.262ms |
| TCPDF | 9.851ms | 10.852ms | 11.974ms | 20.511ms | 31.290ms |
| mPDF | 24.962ms | 28.751ms | 32.890ms | 64.918ms | 104.092ms |
| Dompdf | 11.334ms | 15.997ms | 21.471ms | 73.312ms | 162.250ms |

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
| phpdftk | 3.341ms | 3.554ms | 3.845ms | 5.888ms | 8.320ms |
| FPDF | 1.013ms | 1.100ms | 1.210ms | 1.855ms | 2.728ms |
| TCPDF | 17.015ms | 18.045ms | 19.357ms | 29.079ms | 41.347ms |

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
| Pdf (Level 3) | 3.364ms | 4.431ms | 12.715ms |
| PdfDoc (Level 2) | 2.675ms | 3.146ms | 7.527ms |
| PdfWriter (Level 1) | 2.290ms | 2.770ms | 6.885ms |

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
| Pdf (Level 3) | 4.495ms | 12.374ms | 47.865ms |
| PdfDoc (Level 2) | 3.827ms | 10.140ms | — |

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
| Pdf (Level 3) | 4.099ms | 11.916ms | 45.807ms |
| PdfDoc (Level 2) | 3.386ms | 7.492ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.331ms | 1.686ms | 6.025ms |
| smalot/pdfparser | 2.047ms | 2.460ms | 5.803ms |
| setasign/fpdi | 1.977ms | 2.850ms | 29.929ms |

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
| phpdftk | 2.044ms | 1.427ms |
| smalot/pdfparser | FAIL | 1.975ms |
| setasign/fpdi | 3.068ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.282mb  | 10.377ms  | ±0.48%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.176mb  | 10.504ms  | ±1.39%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.999mb  | 11.928ms  | ±1.27%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.025mb  | 12.071ms  | ±0.83%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.444mb  | 11.372ms  | ±1.18%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.581mb  | 10.688ms  | ±1.13%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.826mb | 19.656ms  | ±1.35%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 3.068ms   | ±2.40%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.099ms   | ±0.66%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.916ms  | ±0.86%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.807ms  | ±11.86% |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.386ms   | ±1.00%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.492ms   | ±0.71%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.959μs   | ±12.07% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.085μs   | ±26.76% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 14.824mb | 16.086ms  | ±0.35%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 14.824mb | 16.509ms  | ±1.07%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 15.627mb | 56.686ms  | ±0.23%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.218mb | 114.426ms | ±2.80%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.093mb | 1.345s    | ±1.67%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.156mb | 26.752ms  | ±2.38%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.182mb | 60.679ms  | ±0.91%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.993mb | 562.674ms | ±0.43%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.439mb | 65.638ms  | ±8.83%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.159mb | 87.376ms  | ±1.51%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.862mb | 746.646ms | ±0.32%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.204mb | 19.149ms  | ±0.94%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.204mb | 44.014ms  | ±1.80%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.846mb | 328.704ms | ±0.42%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.495ms   | ±0.79%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.374ms  | ±0.46%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.865ms  | ±5.21%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.827ms   | ±0.72%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.140ms  | ±1.01%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.265ms   | ±0.82%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.686ms   | ±1.01%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.025ms   | ±1.10%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.044ms   | ±0.50%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.427ms   | ±16.30% |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.047ms   | ±1.18%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.460ms   | ±0.63%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.803ms   | ±1.99%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 559.218μs | ±1.89%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.975ms   | ±1.02%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.977ms   | ±1.17%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.850ms   | ±0.77%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.929ms  | ±1.21%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.068ms   | ±1.18%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.539ms   | ±1.08%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.363ms   | ±0.42%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.521ms   | ±0.79%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.934ms   | ±1.52%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.808μs   | ±18.88% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.331ms   | ±1.46%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.443mb  | 26.219ms  | ±2.28%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.452mb | 228.482ms | ±0.31%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.070mb | 1.144s    | ±1.04%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.290ms   | ±1.47%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.770ms   | ±1.05%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.885ms   | ±1.54%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.675ms   | ±3.86%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.146ms   | ±1.00%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.527ms   | ±0.77%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.364ms   | ±0.57%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.431ms   | ±0.60%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.715ms  | ±3.90%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.298ms   | ±1.18%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.492ms   | ±0.70%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.734ms   | ±0.87%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.749ms   | ±0.54%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.008ms   | ±0.55%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.531ms   | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.837ms   | ±0.86%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.399ms  | ±18.66% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.645ms   | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.379ms   | ±0.92%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 641.594μs | ±2.01%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.161ms   | ±0.32%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.649ms   | ±0.70%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.191ms   | ±0.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 164.800ms | ±28.15% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.587ms   | ±0.29%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.817ms   | ±27.98% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 5.995ms   | ±0.40%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.851ms   | ±3.36%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.852ms  | ±1.99%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.974ms  | ±0.99%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.511ms  | ±1.68%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.290ms  | ±0.32%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 751.149μs | ±2.62%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 821.830μs | ±0.81%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 932.378μs | ±2.83%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.518ms   | ±0.65%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.262ms   | ±0.74%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 24.962ms  | ±1.22%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.751ms  | ±0.12%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.890ms  | ±0.87%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 64.918ms  | ±0.25%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 104.092ms | ±0.71%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.334ms  | ±0.17%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.997ms  | ±0.40%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.471ms  | ±0.58%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 73.312ms  | ±0.52%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 162.250ms | ±0.25%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.061ms   | ±1.07%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.150ms  | ±0.77%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 205.574ms | ±14.25% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 458.358μs | ±0.89%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.968ms   | ±0.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.404ms   | ±0.46%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 13.914ms  | ±6.60%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 87.054ms  | ±0.74%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.817ms  | ±2.06%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.986ms  | ±8.51%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 191.999ms | ±25.13% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.442ms  | ±0.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.487ms  | ±0.89%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.452ms  | ±0.96%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.518ms  | ±0.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 13.826ms  | ±0.71%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.118ms   | ±0.86%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.460ms  | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.476ms  | ±1.02%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.221ms  | ±0.24%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.341ms   | ±0.83%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.554ms   | ±1.59%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.845ms   | ±1.12%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.888ms   | ±0.14%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.320ms   | ±0.11%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.015ms  | ±0.32%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.045ms  | ±0.50%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.357ms  | ±1.63%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.079ms  | ±0.54%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.347ms  | ±0.18%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.013ms   | ±2.46%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.100ms   | ±1.47%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.210ms   | ±1.65%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.855ms   | ±0.78%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.728ms   | ±0.03%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.023μs  | ±6.86%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 241.560μs | ±0.42%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 15.917mb | 81.464ms  | ±0.16%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.972mb | 354.580ms | ±0.41%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.635mb | 1.397s    | ±0.18%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.162mb | 244.091ms | ±0.77%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.745mb | 189.487ms | ±0.78%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 16.700mb | 154.655ms | ±0.39%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 17.753mb | 209.797ms | ±0.65%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.302mb | 173.911ms | ±0.25%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 19.797mb | 328.054ms | ±0.83%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.375mb | 50.064ms  | ±0.44%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.360mb | 43.634ms  | ±0.57%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.289mb | 41.204ms  | ±0.24%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.525mb | 137.333ms | ±0.21%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.284mb | 45.812ms  | ±0.10%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.495mb | 57.345ms  | ±1.13%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 15.912mb | 85.992ms  | ±0.70%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.190mb | 37.026ms  | ±0.69%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.193mb | 44.985ms  | ±0.36%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.221mb | 46.857ms  | ±0.64%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.189mb | 45.756ms  | ±0.94%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.212mb | 44.487ms  | ±0.65%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.399mb | 70.812ms  | ±0.83%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.452mb | 42.701ms  | ±0.32%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.128mb | 38.344ms  | ±0.11%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.158mb | 41.378ms  | ±0.21%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.179mb | 46.803ms  | ±0.38%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.172mb | 45.944ms  | ±0.39%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.620mb | 41.929ms  | ±0.18%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.544mb | 218.060ms | ±0.30%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 15.821mb | 168.704ms | ±0.61%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 8.999ms   | ±0.77%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.535ms   | ±0.68%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.613ms   | ±0.88%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```