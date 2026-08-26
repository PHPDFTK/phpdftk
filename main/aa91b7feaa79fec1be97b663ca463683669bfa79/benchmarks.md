# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-26 17:10:31 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.179ms | 2.538ms | 2.783ms | 4.771ms | 7.093ms |
| FPDF | 777.627μs | 847.677μs | 925.187μs | 1.513ms | 2.266ms |
| TCPDF | 10.517ms | 11.157ms | 12.143ms | 20.682ms | 31.305ms |
| mPDF | 26.458ms | 30.511ms | 34.407ms | 65.591ms | 106.661ms |
| Dompdf | 11.559ms | 16.283ms | 22.282ms | 75.206ms | 165.749ms |

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
| phpdftk | 3.336ms | 3.545ms | 3.849ms | 5.821ms | 8.326ms |
| FPDF | 1.016ms | 1.123ms | 1.202ms | 1.894ms | 2.757ms |
| TCPDF | 17.255ms | 18.153ms | 19.431ms | 29.367ms | 41.529ms |

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
| Pdf (Level 3) | 3.380ms | 4.520ms | 12.563ms |
| PdfDoc (Level 2) | 2.694ms | 3.139ms | 7.533ms |
| PdfWriter (Level 1) | 2.285ms | 2.784ms | 6.910ms |

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
| Pdf (Level 3) | 4.433ms | 12.327ms | 47.379ms |
| PdfDoc (Level 2) | 3.792ms | 10.071ms | — |

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
| Pdf (Level 3) | 4.106ms | 11.956ms | 45.479ms |
| PdfDoc (Level 2) | 3.284ms | 7.370ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.141ms | 1.652ms | 5.953ms |
| smalot/pdfparser | 2.023ms | 2.377ms | 5.739ms |
| setasign/fpdi | 1.933ms | 2.832ms | 29.677ms |

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
| phpdftk | 2.012ms | 1.380ms |
| smalot/pdfparser | FAIL | 1.945ms |
| setasign/fpdi | 2.995ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.265mb  | 10.267ms  | ±4.81%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.159mb  | 10.279ms  | ±1.22%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.982mb  | 11.785ms  | ±0.55%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.007mb  | 11.916ms  | ±0.25%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.426mb  | 10.970ms  | ±0.70%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.563mb  | 10.347ms  | ±0.92%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.808mb | 19.975ms  | ±1.26%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 3.065ms   | ±0.49%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.106ms   | ±3.51%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.956ms  | ±1.24%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.479ms  | ±0.42%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.284ms   | ±1.57%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.370ms   | ±1.00%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.836μs   | ±14.14% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.986μs   | ±26.50% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 14.662mb | 15.606ms  | ±1.54%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 14.662mb | 15.615ms  | ±0.50%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 15.465mb | 55.018ms  | ±0.36%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.056mb | 111.831ms | ±0.36%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.920mb | 1.342s    | ±0.58%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.114mb | 26.221ms  | ±2.94%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.140mb | 58.850ms  | ±1.04%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.951mb | 573.990ms | ±0.87%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.397mb | 66.458ms  | ±8.72%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.117mb | 85.959ms  | ±1.62%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.820mb | 742.276ms | ±0.31%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.162mb | 18.788ms  | ±2.17%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.162mb | 42.857ms  | ±0.51%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.804mb | 326.201ms | ±0.21%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.433ms   | ±1.47%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.327ms  | ±0.70%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.379ms  | ±0.50%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.792ms   | ±1.11%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.071ms  | ±0.44%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.235ms   | ±0.26%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.652ms   | ±0.90%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.953ms   | ±1.83%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.012ms   | ±0.87%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.380ms   | ±0.69%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.023ms   | ±0.50%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.377ms   | ±0.66%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.739ms   | ±0.65%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 562.005μs | ±1.72%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.945ms   | ±1.09%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.933ms   | ±1.56%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.832ms   | ±0.63%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.677ms  | ±0.96%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.995ms   | ±0.92%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.530ms   | ±0.60%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.271ms   | ±0.89%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.412ms   | ±0.55%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.880ms   | ±0.60%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.397μs   | ±18.73% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.141ms   | ±0.99%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.426mb  | 25.711ms  | ±0.85%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.434mb | 231.404ms | ±0.70%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.052mb | 1.132s    | ±0.45%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.285ms   | ±1.27%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.784ms   | ±0.48%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.910ms   | ±0.78%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.694ms   | ±0.51%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.139ms   | ±0.97%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.533ms   | ±2.01%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.380ms   | ±2.63%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.520ms   | ±1.66%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.563ms  | ±0.58%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.334ms   | ±0.78%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.538ms   | ±2.37%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.783ms   | ±1.09%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.771ms   | ±1.06%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.093ms   | ±0.60%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.586ms   | ±0.94%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.849ms   | ±0.15%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.458ms  | ±1.03%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.649ms   | ±0.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.403ms   | ±0.53%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 659.999μs | ±20.54% |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.195ms   | ±1.50%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.689ms   | ±0.88%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.252ms   | ±0.82%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 258.995ms | ±31.31% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.694ms   | ±2.91%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 6.125ms   | ±28.42% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.218ms   | ±2.04%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.517ms  | ±1.58%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.157ms  | ±2.48%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.143ms  | ±2.21%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.682ms  | ±1.00%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.305ms  | ±0.74%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 777.627μs | ±2.26%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 847.677μs | ±1.89%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 925.187μs | ±1.37%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.513ms   | ±1.56%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.266ms   | ±0.52%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 26.458ms  | ±1.71%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 30.511ms  | ±4.45%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 34.407ms  | ±12.26% |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.591ms  | ±0.94%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 106.661ms | ±0.43%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.559ms  | ±1.42%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.283ms  | ±1.48%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 22.282ms  | ±2.34%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 75.206ms  | ±1.17%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 165.749ms | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.102ms   | ±1.21%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 51.201ms  | ±0.60%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.665μs   | ±17.39% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 208.732ms | ±15.49% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 462.425μs | ±2.06%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.049ms   | ±1.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.369ms   | ±0.79%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 13.805ms  | ±6.18%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 86.614ms  | ±1.41%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 15.006ms  | ±2.24%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.386ms  | ±1.28%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 218.785ms | ±18.26% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.436ms  | ±0.57%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.423ms  | ±0.49%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.459ms  | ±1.12%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.677ms  | ±0.58%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.049ms  | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.181ms   | ±0.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.653ms  | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.436ms  | ±0.82%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.179ms  | ±0.58%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.336ms   | ±0.36%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.545ms   | ±0.54%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.849ms   | ±0.14%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.821ms   | ±1.02%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.326ms   | ±0.32%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.255ms  | ±0.30%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.153ms  | ±0.69%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.431ms  | ±0.30%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.367ms  | ±0.73%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.529ms  | ±0.64%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.016ms   | ±3.68%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.123ms   | ±1.80%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.202ms   | ±1.71%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.894ms   | ±0.11%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.757ms   | ±1.49%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.181μs  | ±0.88%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 243.054μs | ±2.38%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 15.690mb | 81.499ms  | ±0.23%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.865mb | 355.840ms | ±0.15%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.528mb | 1.397s    | ±0.23%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.055mb | 248.238ms | ±0.31%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.638mb | 191.963ms | ±0.67%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 16.475mb | 156.678ms | ±0.45%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 17.525mb | 212.421ms | ±0.48%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.140mb | 175.118ms | ±0.92%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 19.635mb | 328.339ms | ±0.87%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.213mb | 50.778ms  | ±0.78%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.133mb | 44.921ms  | ±1.13%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.062mb | 42.198ms  | ±1.05%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.363mb | 138.132ms | ±0.86%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.122mb | 47.247ms  | ±0.31%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.333mb | 59.235ms  | ±0.74%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 15.750mb | 88.127ms  | ±1.63%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.029mb | 38.725ms  | ±0.73%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.031mb | 46.130ms  | ±1.11%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.059mb | 48.012ms  | ±0.22%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.028mb | 46.951ms  | ±0.37%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.050mb | 45.146ms  | ±0.38%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.292mb | 71.183ms  | ±0.35%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.345mb | 43.652ms  | ±0.53%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.021mb | 38.460ms  | ±0.58%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.996mb | 42.022ms  | ±0.37%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.017mb | 47.042ms  | ±0.70%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.010mb | 47.037ms  | ±0.64%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.512mb | 42.266ms  | ±0.73%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.382mb | 218.439ms | ±0.37%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 15.594mb | 172.710ms | ±3.22%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.131ms   | ±1.48%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.622ms   | ±6.96%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.636ms   | ±0.92%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```