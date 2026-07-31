# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-31 07:06:36 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.277ms | 2.493ms | 2.749ms | 4.777ms | 6.997ms |
| FPDF | 760.980μs | 812.379μs | 904.027μs | 1.494ms | 2.253ms |
| TCPDF | 9.894ms | 10.884ms | 11.907ms | 20.403ms | 31.219ms |
| mPDF | 25.026ms | 28.755ms | 32.897ms | 64.440ms | 104.992ms |
| Dompdf | 11.524ms | 15.936ms | 21.562ms | 73.485ms | 162.978ms |

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
| phpdftk | 3.321ms | 3.543ms | 3.817ms | 5.790ms | 8.379ms |
| FPDF | 1.012ms | 1.115ms | 1.193ms | 1.971ms | 2.742ms |
| TCPDF | 17.016ms | 18.029ms | 19.421ms | 29.162ms | 41.176ms |

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
| Pdf (Level 3) | 3.349ms | 4.463ms | 12.615ms |
| PdfDoc (Level 2) | 2.674ms | 3.147ms | 7.634ms |
| PdfWriter (Level 1) | 2.308ms | 2.779ms | 6.923ms |

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
| Pdf (Level 3) | 4.328ms | 12.192ms | 47.233ms |
| PdfDoc (Level 2) | 3.757ms | 10.022ms | — |

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
| Pdf (Level 3) | 4.072ms | 11.665ms | 45.614ms |
| PdfDoc (Level 2) | 3.283ms | 7.305ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.175ms | 1.675ms | 5.963ms |
| smalot/pdfparser | 2.011ms | 2.371ms | 5.732ms |
| setasign/fpdi | 1.920ms | 2.865ms | 29.750ms |

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
| phpdftk | 2.019ms | 1.368ms |
| smalot/pdfparser | FAIL | 1.923ms |
| setasign/fpdi | 2.972ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.044ms   | ±3.64%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.474ms   | ±0.69%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.585ms   | ±0.35%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.215mb  | 10.041ms  | ±1.86%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.087mb  | 10.035ms  | ±0.79%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.913mb  | 11.652ms  | ±0.11%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.957mb  | 11.824ms  | ±1.20%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.376mb  | 10.890ms  | ±0.27%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.514mb  | 10.182ms  | ±0.90%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.756mb | 19.199ms  | ±0.32%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.731mb  | 3.000ms   | ±0.09%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.279mb  | 24.333ms  | ±1.08%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.264mb | 214.585ms | ±0.67%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.780mb | 1.065s    | ±0.61%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.959μs   | ±12.07% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.915μs   | ±26.76% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.942mb | 15.018ms  | ±0.19%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.942mb | 14.984ms  | ±0.36%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.288ms   | ±16.87% |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.493ms   | ±0.82%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.749ms   | ±2.70%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.777ms   | ±0.52%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 6.997ms   | ±1.12%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.567ms   | ±0.61%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.816ms   | ±0.36%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.545ms  | ±9.77%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.626ms   | ±1.01%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.375ms   | ±0.63%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 630.724μs | ±2.10%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.172ms   | ±0.89%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.619ms   | ±0.91%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.192ms   | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 211.923ms | ±17.52% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.562ms   | ±0.54%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.815ms   | ±46.26% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 5.976ms   | ±0.59%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.894ms   | ±1.65%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.884ms  | ±0.26%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.907ms  | ±1.61%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.403ms  | ±0.44%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.219ms  | ±0.58%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 760.980μs | ±2.23%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 812.379μs | ±1.77%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 904.027μs | ±0.82%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.494ms   | ±1.32%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.253ms   | ±0.38%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.026ms  | ±1.70%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.755ms  | ±0.18%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.897ms  | ±0.44%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 64.440ms  | ±0.79%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 104.992ms | ±0.46%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.524ms  | ±40.41% |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.936ms  | ±0.47%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.562ms  | ±0.53%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 73.485ms  | ±0.60%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 162.978ms | ±0.56%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.116ms   | ±0.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.543ms  | ±0.61%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.344μs   | ±86.19% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.665μs   | ±17.39% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 199.318ms | ±9.12%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 456.264μs | ±0.95%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.044ms   | ±1.28%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.388ms   | ±0.62%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 14.021ms  | ±7.06%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 86.335ms  | ±0.76%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.688ms  | ±1.45%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.171ms  | ±8.37%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 236.307ms | ±30.12% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.483ms  | ±0.40%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.494ms  | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.515ms  | ±0.43%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.560ms  | ±0.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 13.892ms  | ±0.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.121ms   | ±1.20%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.520ms  | ±0.34%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.617ms  | ±0.68%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.277ms  | ±0.52%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.230ms   | ±0.63%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.675ms   | ±1.11%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.963ms   | ±2.13%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.019ms   | ±0.73%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.368ms   | ±0.52%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.011ms   | ±0.67%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.371ms   | ±0.99%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.732ms   | ±0.60%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 551.731μs | ±0.98%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.923ms   | ±0.98%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.920ms   | ±0.85%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.865ms   | ±0.77%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.750ms  | ±0.84%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.972ms   | ±0.81%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.507ms   | ±1.25%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.317ms   | ±0.80%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.443ms   | ±0.58%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.857ms   | ±0.65%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.212μs   | ±2.89%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.175ms   | ±1.11%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.678mb | 52.377ms  | ±0.98%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 15.266mb | 106.968ms | ±0.60%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.413mb | 1.278s    | ±0.69%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.823mb | 25.963ms  | ±1.14%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.849mb | 58.131ms  | ±0.70%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.595mb | 519.627ms | ±0.16%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.106mb | 63.724ms  | ±8.75%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.760mb | 85.263ms  | ±1.32%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.529mb | 731.254ms | ±0.50%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.871mb | 21.270ms  | ±0.39%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.871mb | 45.814ms  | ±0.32%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.513mb | 321.202ms | ±0.84%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.086μs  | ±0.73%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 240.129μs | ±0.73%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.328ms   | ±1.69%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.192ms  | ±0.81%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.233ms  | ±0.70%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.757ms   | ±0.36%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.022ms  | ±1.69%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.966mb | 77.911ms  | ±0.40%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.384mb | 335.349ms | ±0.38%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.003mb | 1.325s    | ±0.06%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.860mb | 235.626ms | ±0.47%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.165mb | 184.583ms | ±0.30%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.753mb | 148.365ms | ±0.41%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.789mb | 200.130ms | ±0.53%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 16.346mb | 164.604ms | ±0.13%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.825mb | 311.075ms | ±0.84%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 14.493mb | 47.686ms  | ±0.30%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 14.412mb | 41.461ms  | ±0.68%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 14.341mb | 39.311ms  | ±0.35%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 15.642mb | 131.215ms | ±0.38%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 14.401mb | 44.032ms  | ±0.35%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 14.613mb | 55.038ms  | ±0.66%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 15.029mb | 80.943ms  | ±0.70%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 14.308mb | 35.178ms  | ±0.11%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 14.517mb | 43.140ms  | ±0.57%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 14.338mb | 45.122ms  | ±0.49%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 14.373mb | 43.630ms  | ±0.45%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 14.329mb | 42.365ms  | ±0.43%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 29.836mb | 118.941ms | ±0.40%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 16.813mb | 41.961ms  | ±0.60%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 15.565mb | 37.066ms  | ±0.66%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.275mb | 40.192ms  | ±0.34%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.306mb | 45.257ms  | ±0.47%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.289mb | 44.974ms  | ±0.32%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 17.980mb | 40.682ms  | ±0.29%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.589mb | 206.466ms | ±0.66%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.872mb | 166.587ms | ±1.42%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.072ms   | ±0.54%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.665ms  | ±0.62%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.614ms  | ±0.37%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.283ms   | ±1.96%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.305ms   | ±0.09%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.308ms   | ±0.39%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.779ms   | ±1.13%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.923ms   | ±0.15%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.674ms   | ±0.53%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.147ms   | ±0.79%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.634ms   | ±0.72%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.349ms   | ±0.24%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.463ms   | ±0.59%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.615ms  | ±0.53%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.321ms   | ±0.39%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.543ms   | ±0.60%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.817ms   | ±0.30%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.790ms   | ±0.85%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.379ms   | ±0.80%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.016ms  | ±0.59%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.029ms  | ±0.43%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.421ms  | ±0.25%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.162ms  | ±0.21%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.176ms  | ±0.93%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.012ms   | ±2.19%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.115ms   | ±1.24%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.193ms   | ±1.77%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.971ms   | ±8.74%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.742ms   | ±1.09%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```