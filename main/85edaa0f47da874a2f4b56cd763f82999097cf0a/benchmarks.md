# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-31 15:44:22 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.832ms | 2.590ms | 2.882ms | 4.923ms | 7.389ms |
| FPDF | 777.119μs | 841.227μs | 991.030μs | 1.519ms | 2.265ms |
| TCPDF | 10.005ms | 11.015ms | 12.395ms | 21.007ms | 31.711ms |
| mPDF | 25.815ms | 29.806ms | 34.157ms | 66.353ms | 108.185ms |
| Dompdf | 11.981ms | 16.279ms | 23.115ms | 76.302ms | 169.685ms |

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
| phpdftk | 3.362ms | 3.699ms | 3.947ms | 5.953ms | 8.393ms |
| FPDF | 1.066ms | 1.179ms | 1.259ms | 1.927ms | 2.847ms |
| TCPDF | 17.510ms | 18.632ms | 19.543ms | 29.876ms | 41.698ms |

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
| Pdf (Level 3) | 3.487ms | 4.582ms | 13.009ms |
| PdfDoc (Level 2) | 2.820ms | 3.353ms | 7.941ms |
| PdfWriter (Level 1) | 2.394ms | 2.785ms | 7.136ms |

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
| Pdf (Level 3) | 4.454ms | 12.330ms | 47.483ms |
| PdfDoc (Level 2) | 3.846ms | 10.255ms | — |

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
| Pdf (Level 3) | 4.256ms | 11.936ms | 45.677ms |
| PdfDoc (Level 2) | 3.316ms | 7.469ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.321ms | 1.716ms | 5.949ms |
| smalot/pdfparser | 2.089ms | 2.431ms | 5.874ms |
| setasign/fpdi | 2.023ms | 2.866ms | 29.932ms |

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
| phpdftk | 2.059ms | 1.380ms |
| smalot/pdfparser | FAIL | 1.990ms |
| setasign/fpdi | 3.165ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.498ms   | ±14.92%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.943ms   | ±7.56%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.809ms   | ±1.22%   |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.215mb  | 10.525ms  | ±1.39%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.087mb  | 10.763ms  | ±0.56%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.913mb  | 12.349ms  | ±1.21%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.957mb  | 12.257ms  | ±3.27%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.376mb  | 11.787ms  | ±5.63%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.514mb  | 10.715ms  | ±1.15%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.756mb | 20.325ms  | ±0.48%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.731mb  | 3.306ms   | ±0.98%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.284mb  | 24.924ms  | ±0.71%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.270mb | 219.482ms | ±1.01%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.785mb | 1.062s    | ±0.98%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.049μs   | ±16.64%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.303μs   | ±64.28%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.952mb | 15.074ms  | ±0.35%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.952mb | 15.243ms  | ±0.82%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.323ms   | ±2.79%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.590ms   | ±1.30%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.882ms   | ±10.44%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.923ms   | ±0.98%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.389ms   | ±1.01%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.625ms   | ±0.98%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.920ms   | ±2.06%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.721ms  | ±6.96%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.635ms   | ±0.74%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.402ms   | ±2.28%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 666.322μs | ±3.92%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.183ms   | ±0.86%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 4.711ms   | ±158.67% |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.265ms   | ±2.53%   |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 228.396ms | ±29.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.643ms   | ±1.16%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.814ms   | ±20.09%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.068ms   | ±0.50%   |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.005ms  | ±1.33%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.015ms  | ±0.70%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.395ms  | ±1.88%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 21.007ms  | ±1.29%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.711ms  | ±2.17%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 777.119μs | ±6.72%   |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 841.227μs | ±1.87%   |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 991.030μs | ±2.76%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.519ms   | ±0.70%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.265ms   | ±2.06%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.815ms  | ±2.47%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.806ms  | ±4.91%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 34.157ms  | ±2.61%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 66.353ms  | ±1.32%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 108.185ms | ±1.06%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.981ms  | ±2.08%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.279ms  | ±1.09%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 23.115ms  | ±1.05%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 76.302ms  | ±0.94%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 169.685ms | ±1.22%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.265ms   | ±1.41%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.923ms  | ±1.72%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 167.741ms | ±46.86%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 471.108μs | ±1.48%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.058ms   | ±2.67%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.586ms   | ±1.71%   |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 14.371ms  | ±1.97%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 87.939ms  | ±1.53%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 15.155ms  | ±6.50%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.208ms  | ±1.58%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 234.505ms | ±10.15%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 14.071ms  | ±0.98%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 14.029ms  | ±1.01%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.908ms  | ±0.85%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.910ms  | ±0.89%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.430ms  | ±0.78%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.338ms   | ±4.48%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.841ms  | ±1.20%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.910ms  | ±5.25%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.832ms  | ±14.97%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.291ms   | ±1.68%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.716ms   | ±0.90%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.949ms   | ±1.15%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.059ms   | ±0.56%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.380ms   | ±1.86%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.089ms   | ±1.94%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.431ms   | ±0.83%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.874ms   | ±1.98%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 569.057μs | ±1.46%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.990ms   | ±2.59%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 2.023ms   | ±1.18%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.866ms   | ±1.75%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.932ms  | ±2.10%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.165ms   | ±13.82%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.606ms   | ±1.90%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.424ms   | ±0.78%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.528ms   | ±0.99%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.953ms   | ±1.00%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.812μs   | ±2.44%   |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.321ms   | ±1.16%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.688mb | 53.245ms  | ±0.36%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 15.276mb | 109.275ms | ±0.44%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.423mb | 1.294s    | ±0.85%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.833mb | 27.186ms  | ±1.02%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.859mb | 60.179ms  | ±1.66%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.605mb | 566.389ms | ±1.37%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.116mb | 67.096ms  | ±9.80%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.770mb | 89.700ms  | ±0.58%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.539mb | 750.824ms | ±0.32%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.881mb | 22.076ms  | ±1.11%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.881mb | 47.319ms  | ±0.26%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.523mb | 332.224ms | ±0.63%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.430μs  | ±0.63%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 243.543μs | ±1.93%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.454ms   | ±1.75%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.330ms  | ±0.67%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.483ms  | ±0.84%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.846ms   | ±2.85%   |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.255ms  | ±0.55%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.976mb | 80.692ms  | ±2.05%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.393mb | 341.259ms | ±0.93%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.013mb | 1.358s    | ±0.69%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.870mb | 244.373ms | ±0.91%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.175mb | 190.209ms | ±0.28%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.763mb | 151.458ms | ±0.60%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.799mb | 203.297ms | ±2.46%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 16.356mb | 171.254ms | ±1.52%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.834mb | 325.214ms | ±0.64%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 14.503mb | 48.764ms  | ±0.31%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 14.422mb | 43.010ms  | ±0.25%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 14.351mb | 40.986ms  | ±0.31%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 15.652mb | 134.022ms | ±2.13%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 14.411mb | 44.601ms  | ±0.33%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 14.623mb | 57.700ms  | ±2.25%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 15.039mb | 84.297ms  | ±0.70%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 14.318mb | 36.581ms  | ±1.07%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 14.527mb | 44.571ms  | ±3.30%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 14.348mb | 46.970ms  | ±1.13%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 14.383mb | 44.956ms  | ±0.31%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 14.338mb | 43.702ms  | ±0.69%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 29.846mb | 120.823ms | ±1.22%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 16.823mb | 43.032ms  | ±3.98%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 15.575mb | 38.162ms  | ±1.98%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.285mb | 41.354ms  | ±0.93%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.316mb | 46.535ms  | ±0.08%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.299mb | 45.843ms  | ±0.67%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 17.990mb | 42.907ms  | ±1.20%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.599mb | 216.985ms | ±0.21%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.882mb | 171.449ms | ±0.59%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.256ms   | ±3.62%   |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.936ms  | ±2.06%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.677ms  | ±0.36%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.316ms   | ±3.31%   |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.469ms   | ±9.01%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.394ms   | ±1.82%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.785ms   | ±2.68%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 7.136ms   | ±0.46%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.820ms   | ±6.37%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.353ms   | ±1.11%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.941ms   | ±0.65%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.487ms   | ±1.97%   |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.582ms   | ±1.29%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 13.009ms  | ±2.28%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.362ms   | ±1.11%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.699ms   | ±0.28%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.947ms   | ±1.29%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.953ms   | ±0.73%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.393ms   | ±1.29%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.510ms  | ±0.56%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.632ms  | ±2.38%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.543ms  | ±0.31%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.876ms  | ±0.33%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.698ms  | ±0.72%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.066ms   | ±2.38%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.179ms   | ±1.32%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.259ms   | ±1.52%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.927ms   | ±1.19%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.847ms   | ±4.46%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```