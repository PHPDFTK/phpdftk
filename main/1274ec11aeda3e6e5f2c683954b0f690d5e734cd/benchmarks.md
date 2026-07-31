# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-31 15:48:43 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.468ms | 2.582ms | 2.798ms | 4.821ms | 7.145ms |
| FPDF | 811.064μs | 859.768μs | 915.645μs | 1.529ms | 2.252ms |
| TCPDF | 10.054ms | 10.982ms | 12.144ms | 20.750ms | 31.675ms |
| mPDF | 25.593ms | 29.415ms | 33.708ms | 65.463ms | 106.312ms |
| Dompdf | 11.376ms | 16.079ms | 21.639ms | 74.530ms | 163.844ms |

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
| phpdftk | 3.394ms | 3.632ms | 3.904ms | 5.888ms | 8.407ms |
| FPDF | 1.063ms | 1.097ms | 1.214ms | 1.905ms | 2.729ms |
| TCPDF | 17.372ms | 18.392ms | 19.720ms | 29.161ms | 41.353ms |

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
| Pdf (Level 3) | 3.407ms | 4.525ms | 12.687ms |
| PdfDoc (Level 2) | 2.765ms | 3.176ms | 7.675ms |
| PdfWriter (Level 1) | 2.344ms | 2.793ms | 6.961ms |

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
| Pdf (Level 3) | 4.410ms | 12.166ms | 47.163ms |
| PdfDoc (Level 2) | 3.790ms | 9.979ms | — |

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
| Pdf (Level 3) | 4.055ms | 11.715ms | 45.664ms |
| PdfDoc (Level 2) | 3.290ms | 7.357ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.273ms | 1.700ms | 5.978ms |
| smalot/pdfparser | 2.044ms | 2.412ms | 5.776ms |
| setasign/fpdi | 1.978ms | 2.848ms | 29.462ms |

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
| phpdftk | 2.048ms | 1.383ms |
| smalot/pdfparser | FAIL | 1.923ms |
| setasign/fpdi | 3.006ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.163ms   | ±7.52%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.556ms   | ±0.88%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.607ms   | ±0.54%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.215mb  | 10.192ms  | ±1.88%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.087mb  | 10.231ms  | ±0.68%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.913mb  | 11.890ms  | ±0.51%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.957mb  | 12.000ms  | ±1.81%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.376mb  | 10.943ms  | ±0.86%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.514mb  | 10.475ms  | ±0.89%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.756mb | 19.544ms  | ±0.49%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.731mb  | 3.028ms   | ±2.88%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.284mb  | 24.552ms  | ±0.60%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.270mb | 217.471ms | ±1.40%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.785mb | 1.068s    | ±0.04%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.966μs   | ±19.64% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.121μs   | ±35.36% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.952mb | 15.489ms  | ±0.71%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.952mb | 15.252ms  | ±0.04%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.357ms   | ±0.23%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.582ms   | ±0.79%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.798ms   | ±0.49%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.821ms   | ±0.45%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.145ms   | ±0.77%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.688ms   | ±1.68%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.902ms   | ±1.53%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 13.400ms  | ±93.92% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.709ms   | ±72.89% |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.421ms   | ±5.87%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 727.339μs | ±33.26% |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.194ms   | ±1.19%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.691ms   | ±2.46%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.254ms   | ±0.46%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 191.666ms | ±22.28% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.633ms   | ±0.84%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.808ms   | ±21.74% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.013ms   | ±0.37%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.054ms  | ±0.98%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.982ms  | ±0.38%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.144ms  | ±0.58%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.750ms  | ±0.61%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.675ms  | ±3.02%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 811.064μs | ±4.43%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 859.768μs | ±5.16%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 915.645μs | ±2.13%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.529ms   | ±1.89%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.252ms   | ±0.70%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.593ms  | ±2.08%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.415ms  | ±0.73%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.708ms  | ±0.71%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.463ms  | ±0.56%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 106.312ms | ±0.65%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.376ms  | ±3.42%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.079ms  | ±0.57%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.639ms  | ±0.78%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 74.530ms  | ±0.52%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 163.844ms | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.162ms   | ±0.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.828ms  | ±0.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.431μs   | ±99.20% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.665μs   | ±17.39% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 127.335ms | ±30.26% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 457.710μs | ±1.88%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.011ms   | ±0.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.439ms   | ±0.70%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 12.600ms  | ±4.57%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 85.706ms  | ±1.07%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.566ms  | ±1.54%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 24.756ms  | ±1.32%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 251.733ms | ±20.99% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.539ms  | ±1.01%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.543ms  | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.610ms  | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.625ms  | ±0.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 13.991ms  | ±0.22%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.187ms   | ±3.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.679ms  | ±0.82%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.671ms  | ±0.35%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.468ms  | ±0.93%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.243ms   | ±0.49%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.700ms   | ±0.80%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.978ms   | ±0.73%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.048ms   | ±0.93%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.383ms   | ±1.01%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.044ms   | ±1.40%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.412ms   | ±1.29%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.776ms   | ±0.91%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 555.183μs | ±1.18%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.923ms   | ±0.37%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.978ms   | ±0.49%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.848ms   | ±1.16%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.462ms  | ±1.47%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.006ms   | ±0.94%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.540ms   | ±0.65%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.332ms   | ±0.73%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.478ms   | ±0.67%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.926ms   | ±0.51%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.641μs   | ±7.06%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.273ms   | ±0.85%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.688mb | 52.890ms  | ±0.27%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 15.276mb | 107.781ms | ±1.32%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.423mb | 1.296s    | ±1.09%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.833mb | 26.419ms  | ±1.28%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.859mb | 58.999ms  | ±1.14%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.605mb | 546.666ms | ±0.52%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.116mb | 63.680ms  | ±9.38%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.770mb | 86.942ms  | ±1.18%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.539mb | 733.206ms | ±0.32%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.881mb | 21.604ms  | ±0.16%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.881mb | 46.051ms  | ±1.01%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.523mb | 327.974ms | ±0.21%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.088μs  | ±0.42%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 244.764μs | ±2.79%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.410ms   | ±23.30% |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.166ms  | ±1.17%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.163ms  | ±0.54%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.790ms   | ±1.98%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 9.979ms   | ±1.11%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.976mb | 78.292ms  | ±0.37%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.393mb | 341.588ms | ±0.57%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.013mb | 1.343s    | ±0.64%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.870mb | 237.618ms | ±0.54%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.175mb | 186.806ms | ±0.29%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.763mb | 147.255ms | ±0.34%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.799mb | 201.348ms | ±0.36%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 16.356mb | 165.102ms | ±0.33%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.834mb | 315.053ms | ±0.62%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 14.503mb | 47.908ms  | ±0.50%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 14.422mb | 42.152ms  | ±1.40%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 14.351mb | 40.144ms  | ±1.51%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 15.652mb | 132.221ms | ±0.37%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 14.411mb | 45.145ms  | ±0.42%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 14.623mb | 56.534ms  | ±1.33%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 15.039mb | 82.098ms  | ±1.08%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 14.318mb | 35.267ms  | ±0.17%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 14.527mb | 43.812ms  | ±0.97%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 14.348mb | 45.412ms  | ±0.07%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 14.383mb | 44.365ms  | ±0.61%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 14.338mb | 43.081ms  | ±0.71%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 29.846mb | 119.429ms | ±0.42%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 16.823mb | 42.017ms  | ±0.26%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 15.575mb | 37.908ms  | ±0.69%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.285mb | 40.374ms  | ±0.38%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.316mb | 44.884ms  | ±1.11%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.299mb | 44.697ms  | ±0.24%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 17.990mb | 40.969ms  | ±0.15%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.599mb | 208.727ms | ±0.10%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.882mb | 167.188ms | ±0.20%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.055ms   | ±0.64%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.715ms  | ±9.34%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.664ms  | ±12.03% |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.290ms   | ±2.26%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.357ms   | ±0.36%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.344ms   | ±1.32%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.793ms   | ±11.00% |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.961ms   | ±0.63%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.765ms   | ±3.28%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.176ms   | ±0.89%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.675ms   | ±1.20%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.407ms   | ±1.18%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.525ms   | ±0.72%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.687ms  | ±0.63%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.394ms   | ±4.38%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.632ms   | ±0.85%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.904ms   | ±0.42%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.888ms   | ±0.36%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.407ms   | ±3.71%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.372ms  | ±0.03%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.392ms  | ±0.04%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.720ms  | ±0.85%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.161ms  | ±0.33%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.353ms  | ±0.54%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.063ms   | ±1.57%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.097ms   | ±1.30%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.214ms   | ±0.38%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.905ms   | ±0.30%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.729ms   | ±0.44%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```