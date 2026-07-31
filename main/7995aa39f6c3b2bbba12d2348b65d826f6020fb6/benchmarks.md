# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-31 12:55:42 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.200ms | 2.521ms | 2.745ms | 4.766ms | 7.053ms |
| FPDF | 755.868μs | 814.887μs | 919.090μs | 1.508ms | 2.260ms |
| TCPDF | 9.882ms | 10.932ms | 11.960ms | 20.390ms | 31.261ms |
| mPDF | 24.909ms | 28.800ms | 32.848ms | 64.666ms | 104.158ms |
| Dompdf | 11.421ms | 15.888ms | 21.558ms | 73.658ms | 161.894ms |

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
| phpdftk | 3.291ms | 3.582ms | 3.787ms | 5.846ms | 8.392ms |
| FPDF | 1.016ms | 1.099ms | 1.209ms | 1.879ms | 2.733ms |
| TCPDF | 17.183ms | 18.272ms | 19.579ms | 29.226ms | 41.388ms |

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
| Pdf (Level 3) | 3.355ms | 4.424ms | 12.748ms |
| PdfDoc (Level 2) | 2.677ms | 3.157ms | 7.561ms |
| PdfWriter (Level 1) | 2.312ms | 2.755ms | 6.964ms |

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
| Pdf (Level 3) | 4.350ms | 12.206ms | 46.941ms |
| PdfDoc (Level 2) | 3.754ms | 10.032ms | — |

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
| Pdf (Level 3) | 4.039ms | 11.892ms | 46.039ms |
| PdfDoc (Level 2) | 3.274ms | 7.412ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.156ms | 1.651ms | 5.953ms |
| smalot/pdfparser | 1.988ms | 2.371ms | 5.730ms |
| setasign/fpdi | 1.933ms | 2.815ms | 29.370ms |

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
| phpdftk | 1.998ms | 1.369ms |
| smalot/pdfparser | FAIL | 1.910ms |
| setasign/fpdi | 3.004ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.077ms   | ±0.89%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.603ms   | ±7.55%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.626ms   | ±0.42%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.215mb  | 10.014ms  | ±0.54%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.087mb  | 10.100ms  | ±1.79%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.913mb  | 11.642ms  | ±0.26%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.957mb  | 11.804ms  | ±0.61%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.376mb  | 10.994ms  | ±0.28%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.514mb  | 10.089ms  | ±1.46%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.756mb | 19.313ms  | ±0.91%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.731mb  | 2.950ms   | ±0.64%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.279mb  | 23.917ms  | ±0.21%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.264mb | 212.438ms | ±0.41%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.780mb | 1.074s    | ±0.71%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.861μs   | ±22.10% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.797μs   | ±32.35% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.946mb | 15.085ms  | ±0.05%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.946mb | 15.007ms  | ±0.53%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.300ms   | ±2.48%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.521ms   | ±0.56%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.745ms   | ±0.43%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.766ms   | ±0.85%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.053ms   | ±0.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.547ms   | ±1.13%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.843ms   | ±1.04%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.358ms  | ±15.47% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.609ms   | ±0.49%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.368ms   | ±0.99%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 642.562μs | ±2.25%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.202ms   | ±0.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.645ms   | ±1.41%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.223ms   | ±0.72%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 251.068ms | ±17.10% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.591ms   | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.737ms   | ±20.07% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.064ms   | ±0.66%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.882ms   | ±1.32%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.932ms  | ±0.27%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.960ms  | ±0.63%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.390ms  | ±0.64%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.261ms  | ±2.09%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 755.868μs | ±2.17%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 814.887μs | ±3.79%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 919.090μs | ±1.35%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.508ms   | ±0.79%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.260ms   | ±0.85%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 24.909ms  | ±2.15%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.800ms  | ±2.68%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.848ms  | ±0.14%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 64.666ms  | ±0.43%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 104.158ms | ±0.90%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.421ms  | ±2.58%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.888ms  | ±0.66%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.558ms  | ±0.59%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 73.658ms  | ±0.55%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 161.894ms | ±0.37%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.084ms   | ±1.04%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 49.774ms  | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.344μs   | ±11.13% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.463μs   | ±17.82% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.624μs   | ±18.18% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 170.018ms | ±27.48% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 458.274μs | ±1.21%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.017ms   | ±1.06%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.410ms   | ±1.00%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 14.569ms  | ±2.71%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 87.883ms  | ±0.69%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 15.480ms  | ±1.66%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.606ms  | ±1.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 182.966ms | ±33.93% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.439ms  | ±0.51%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.375ms  | ±0.83%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.471ms  | ±0.23%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.558ms  | ±0.60%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 13.904ms  | ±0.24%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.138ms   | ±0.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.405ms  | ±0.54%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.462ms  | ±0.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.200ms  | ±0.70%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.225ms   | ±0.85%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.651ms   | ±0.91%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.953ms   | ±0.53%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 1.998ms   | ±0.46%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.369ms   | ±0.98%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.988ms   | ±1.21%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.371ms   | ±0.15%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.730ms   | ±0.85%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 553.811μs | ±0.97%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.910ms   | ±0.73%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.933ms   | ±1.70%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.815ms   | ±0.51%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.370ms  | ±0.49%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.004ms   | ±1.20%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.511ms   | ±0.54%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.299ms   | ±0.44%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.451ms   | ±0.38%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.836ms   | ±0.28%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.601μs   | ±46.85% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.156ms   | ±1.17%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.682mb | 51.494ms  | ±0.15%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 15.270mb | 106.173ms | ±0.17%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.418mb | 1.269s    | ±0.14%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.828mb | 25.758ms  | ±1.75%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.854mb | 58.217ms  | ±1.10%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.599mb | 517.092ms | ±0.34%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.111mb | 63.160ms  | ±9.10%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.765mb | 85.224ms  | ±1.32%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.534mb | 727.529ms | ±0.83%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.876mb | 21.299ms  | ±0.30%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.876mb | 45.711ms  | ±0.44%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.518mb | 321.283ms | ±0.36%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 40.792μs  | ±1.14%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 244.611μs | ±2.78%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.350ms   | ±1.07%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.206ms  | ±3.97%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 46.941ms  | ±0.21%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.754ms   | ±0.41%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.032ms  | ±3.28%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.971mb | 77.663ms  | ±0.87%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.388mb | 336.436ms | ±0.55%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.008mb | 1.331s    | ±0.54%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.865mb | 235.584ms | ±0.58%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.169mb | 184.233ms | ±0.08%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.757mb | 147.995ms | ±2.19%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.794mb | 201.812ms | ±0.67%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 16.351mb | 164.689ms | ±0.77%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.829mb | 313.210ms | ±0.36%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 14.497mb | 47.650ms  | ±0.76%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 14.417mb | 41.342ms  | ±0.55%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 14.346mb | 39.409ms  | ±0.48%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 15.647mb | 131.186ms | ±0.37%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 14.406mb | 43.679ms  | ±0.28%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 14.617mb | 55.058ms  | ±0.46%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 15.034mb | 81.912ms  | ±2.44%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 14.312mb | 35.426ms  | ±0.40%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 14.522mb | 43.525ms  | ±0.22%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 14.343mb | 45.022ms  | ±0.40%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 14.377mb | 43.871ms  | ±0.51%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 14.333mb | 42.164ms  | ±0.56%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 29.840mb | 120.238ms | ±1.14%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 16.818mb | 41.765ms  | ±0.72%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 15.570mb | 36.961ms  | ±0.14%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.280mb | 39.988ms  | ±0.31%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.310mb | 45.128ms  | ±0.26%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.294mb | 44.447ms  | ±0.27%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 17.985mb | 40.789ms  | ±0.26%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.594mb | 208.117ms | ±1.02%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.876mb | 165.017ms | ±0.81%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.039ms   | ±0.50%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.892ms  | ±14.37% |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 46.039ms  | ±0.59%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.274ms   | ±2.64%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.412ms   | ±0.87%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.312ms   | ±0.59%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.755ms   | ±0.35%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.964ms   | ±3.77%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.677ms   | ±0.59%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.157ms   | ±0.52%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.561ms   | ±0.57%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.355ms   | ±0.30%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.424ms   | ±0.58%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.748ms  | ±0.43%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.291ms   | ±0.48%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.582ms   | ±0.92%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.787ms   | ±0.76%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.846ms   | ±0.13%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.392ms   | ±0.62%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.183ms  | ±0.39%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.272ms  | ±0.49%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.579ms  | ±0.11%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.226ms  | ±0.23%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.388ms  | ±0.01%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.016ms   | ±1.07%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.099ms   | ±1.00%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.209ms   | ±0.19%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.879ms   | ±0.81%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.733ms   | ±0.33%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```