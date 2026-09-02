# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-02 01:23:20 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 10.836ms | 1.913ms | 2.097ms | 3.626ms | 5.329ms |
| FPDF | 624.519μs | 644.827μs | 718.320μs | 1.180ms | 1.755ms |
| TCPDF | 7.742ms | 8.456ms | 9.215ms | 14.858ms | 21.916ms |
| mPDF | 20.138ms | 22.619ms | 25.614ms | 47.114ms | 74.420ms |
| Dompdf | 8.628ms | 11.812ms | 15.436ms | 51.790ms | 115.779ms |

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
| phpdftk | 2.640ms | 2.823ms | 3.024ms | 4.623ms | 6.541ms |
| FPDF | 1.366ms | 912.028μs | 1.016ms | 1.559ms | 2.155ms |
| TCPDF | 14.391ms | 15.096ms | 15.752ms | 21.827ms | 30.145ms |

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
| Pdf (Level 3) | 2.573ms | 3.361ms | 9.316ms |
| PdfDoc (Level 2) | 2.048ms | 2.422ms | 5.708ms |
| PdfWriter (Level 1) | 1.760ms | 2.093ms | 5.252ms |

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
| Pdf (Level 3) | 3.298ms | 9.230ms | 35.497ms |
| PdfDoc (Level 2) | 11.595ms | 13.792ms | — |

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
| Pdf (Level 3) | 3.120ms | 8.925ms | 34.564ms |
| PdfDoc (Level 2) | 2.522ms | 5.584ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 4.701ms | 1.281ms | 4.648ms |
| smalot/pdfparser | 1.533ms | 1.795ms | 4.226ms |
| setasign/fpdi | 1.455ms | 2.102ms | 22.379ms |

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
| phpdftk | 1.558ms | 1.026ms |
| smalot/pdfparser | FAIL | 1.475ms |
| setasign/fpdi | 2.218ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 7.439ms   | ±1.00%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 7.574ms   | ±0.81%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 8.828ms   | ±0.89%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 8.558ms   | ±0.19%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 8.365ms   | ±0.58%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 7.563ms   | ±0.15%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 13.795ms  | ±1.24%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 2.296ms   | ±0.29%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 3.120ms   | ±36.31%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 8.925ms   | ±0.78%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 34.564ms  | ±6.45%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 2.522ms   | ±11.49%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 5.584ms   | ±0.46%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.836μs   | ±14.14%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.873μs   | ±25.71%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.235mb | 12.211ms  | ±0.33%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.235mb | 12.316ms  | ±0.76%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.038mb | 40.521ms  | ±0.54%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.629mb | 87.639ms  | ±2.09%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.280mb | 975.808ms | ±4.01%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.201mb | 18.357ms  | ±2.96%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.227mb | 39.763ms  | ±1.18%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.038mb | 352.129ms | ±1.11%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.484mb | 49.191ms  | ±9.21%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.204mb | 63.299ms  | ±1.13%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.973mb | 509.900ms | ±1.24%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.249mb | 13.554ms  | ±1.51%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.249mb | 31.961ms  | ±0.45%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.892mb | 214.439ms | ±0.76%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 3.298ms   | ±0.40%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 9.230ms   | ±1.89%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 35.497ms  | ±18.96%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 11.595ms  | ±35.59%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 13.792ms  | ±111.88% |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 937.749μs | ±1.87%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.281ms   | ±0.44%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 4.648ms   | ±0.43%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 1.558ms   | ±0.48%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.026ms   | ±0.60%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.533ms   | ±1.38%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 1.795ms   | ±0.40%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 4.226ms   | ±0.60%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 433.449μs | ±1.21%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.475ms   | ±0.65%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.455ms   | ±0.82%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.102ms   | ±0.93%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 22.379ms  | ±0.48%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.218ms   | ±0.40%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.161ms   | ±1.52%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 5.494ms   | ±0.76%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 4.111ms   | ±0.74%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 2.954ms   | ±0.82%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.085μs   | ±19.04%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 4.701ms   | ±12.44%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 18.655ms  | ±0.32%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 166.378ms | ±0.80%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 837.211ms | ±7.50%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 1.760ms   | ±0.62%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.093ms   | ±1.38%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 5.252ms   | ±0.45%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.048ms   | ±1.35%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 2.422ms   | ±83.89%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 5.708ms   | ±0.40%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 2.573ms   | ±0.53%   |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 3.361ms   | ±0.63%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 9.316ms   | ±0.68%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 1.759ms   | ±0.51%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 1.913ms   | ±1.01%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.097ms   | ±0.47%   |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 3.626ms   | ±0.35%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 5.329ms   | ±0.50%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 2.695ms   | ±0.19%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 2.880ms   | ±0.93%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 10.013ms  | ±14.24%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 2.751ms   | ±0.67%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 1.799ms   | ±0.62%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 494.061μs | ±4.41%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 2.387ms   | ±1.07%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 2.719ms   | ±0.43%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 2.416ms   | ±0.37%   |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 211.273ms | ±39.48%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 2.711ms   | ±0.48%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 4.480ms   | ±29.94%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 4.685ms   | ±77.18%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 7.742ms   | ±0.69%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 8.456ms   | ±5.84%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 9.215ms   | ±0.39%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 14.858ms  | ±0.30%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 21.916ms  | ±0.59%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 624.519μs | ±1.57%   |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 644.827μs | ±1.64%   |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 718.320μs | ±1.20%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.180ms   | ±0.68%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 1.755ms   | ±27.71%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 20.138ms  | ±1.76%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 22.619ms  | ±1.16%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 25.614ms  | ±2.18%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 47.114ms  | ±0.11%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 74.420ms  | ±0.24%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 8.628ms   | ±0.35%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 11.812ms  | ±0.48%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 15.436ms  | ±0.47%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 51.790ms  | ±0.73%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 115.779ms | ±1.19%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 3.823ms   | ±1.80%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 41.757ms  | ±0.92%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.624μs   | ±18.18%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 169.585ms | ±17.18%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 381.937μs | ±0.84%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.261ms   | ±0.93%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 2.575ms   | ±0.29%   |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 8.742ms   | ±6.53%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 63.066ms  | ±1.48%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 11.511ms  | ±1.96%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 20.400ms  | ±1.77%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 123.569ms | ±31.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 10.949ms  | ±0.51%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 11.038ms  | ±0.32%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 11.072ms  | ±0.53%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 10.997ms  | ±0.40%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 11.329ms  | ±0.83%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 2.429ms   | ±0.67%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 10.954ms  | ±0.50%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 10.928ms  | ±0.44%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 10.836ms  | ±1.06%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 2.640ms   | ±0.42%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 2.823ms   | ±0.47%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.024ms   | ±1.08%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 4.623ms   | ±1.09%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 6.541ms   | ±0.85%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 14.391ms  | ±0.14%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 15.096ms  | ±0.84%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 15.752ms  | ±1.09%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 21.827ms  | ±1.19%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 30.145ms  | ±0.60%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.366ms   | ±108.83% |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 912.028μs | ±0.81%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.016ms   | ±0.52%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.559ms   | ±1.11%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.155ms   | ±9.32%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 33.451μs  | ±0.78%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 185.730μs | ±0.43%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.328mb | 60.945ms  | ±3.95%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.159mb | 282.484ms | ±3.74%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.822mb | 1.013s    | ±4.36%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.390mb | 184.909ms | ±0.14%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.946mb | 148.639ms | ±0.25%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.113mb | 116.297ms | ±3.24%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.164mb | 154.755ms | ±0.51%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.713mb | 128.353ms | ±4.36%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.208mb | 245.986ms | ±2.93%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.852mb | 38.138ms  | ±0.20%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.771mb | 34.165ms  | ±1.84%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.700mb | 32.302ms  | ±1.44%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.936mb | 102.457ms | ±1.57%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.760mb | 35.191ms  | ±3.02%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.972mb | 43.802ms  | ±0.19%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.388mb | 64.630ms  | ±0.55%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.667mb | 28.605ms  | ±0.11%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.604mb | 34.758ms  | ±0.40%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.632mb | 36.162ms  | ±0.83%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.601mb | 35.194ms  | ±0.25%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.623mb | 34.165ms  | ±1.99%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.587mb | 55.966ms  | ±0.34%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.640mb | 34.348ms  | ±0.60%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.316mb | 30.129ms  | ±1.95%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.569mb | 32.423ms  | ±2.64%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.590mb | 36.071ms  | ±0.38%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.583mb | 35.952ms  | ±2.09%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.807mb | 33.590ms  | ±1.05%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.955mb | 163.745ms | ±3.41%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.233mb | 126.784ms | ±1.84%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 6.840ms   | ±0.52%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 6.601ms   | ±0.38%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 6.592ms   | ±0.18%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```