# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-31 05:55:03 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.158ms | 2.490ms | 2.729ms | 4.733ms | 7.090ms |
| FPDF | 757.142μs | 841.541μs | 892.635μs | 1.480ms | 2.217ms |
| TCPDF | 9.907ms | 10.852ms | 12.014ms | 20.506ms | 31.055ms |
| mPDF | 25.143ms | 28.786ms | 32.725ms | 64.169ms | 102.831ms |
| Dompdf | 11.239ms | 15.835ms | 21.390ms | 72.749ms | 159.470ms |

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
| phpdftk | 3.295ms | 3.593ms | 3.812ms | 5.791ms | 8.290ms |
| FPDF | 994.396μs | 1.133ms | 1.203ms | 1.891ms | 2.773ms |
| TCPDF | 17.055ms | 18.037ms | 19.634ms | 29.151ms | 40.995ms |

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
| Pdf (Level 3) | 3.380ms | 4.436ms | 12.651ms |
| PdfDoc (Level 2) | 2.664ms | 3.144ms | 7.485ms |
| PdfWriter (Level 1) | 2.303ms | 2.744ms | 6.867ms |

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
| Pdf (Level 3) | 4.319ms | 12.122ms | 46.761ms |
| PdfDoc (Level 2) | 3.762ms | 9.954ms | — |

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
| Pdf (Level 3) | 4.043ms | 11.647ms | 45.113ms |
| PdfDoc (Level 2) | 3.264ms | 7.355ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.251ms | 1.665ms | 5.947ms |
| smalot/pdfparser | 1.990ms | 2.375ms | 5.746ms |
| setasign/fpdi | 1.931ms | 2.830ms | 29.735ms |

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
| phpdftk | 2.020ms | 1.354ms |
| smalot/pdfparser | FAIL | 1.916ms |
| setasign/fpdi | 2.969ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 8.894ms   | ±0.69%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.593ms   | ±7.68%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.596ms   | ±6.92%   |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.215mb  | 10.097ms  | ±0.76%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.087mb  | 10.015ms  | ±0.48%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.913mb  | 11.581ms  | ±1.86%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.957mb  | 11.767ms  | ±0.08%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.376mb  | 10.892ms  | ±0.48%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.514mb  | 10.120ms  | ±0.47%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.756mb | 19.009ms  | ±0.63%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.731mb  | 2.961ms   | ±0.25%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.279mb  | 24.099ms  | ±0.41%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.264mb | 216.854ms | ±1.57%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.780mb | 1.060s    | ±0.34%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.359μs   | ±54.55%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.786μs   | ±28.98%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.887mb | 15.035ms  | ±0.63%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.887mb | 14.833ms  | ±0.40%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.290ms   | ±0.50%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.490ms   | ±0.80%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.729ms   | ±0.77%   |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.733ms   | ±0.52%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.090ms   | ±0.57%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.540ms   | ±0.68%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.819ms   | ±1.11%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.283ms  | ±7.68%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.582ms   | ±2.46%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.367ms   | ±7.19%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 640.568μs | ±3.72%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.167ms   | ±0.92%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.633ms   | ±0.98%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.542ms   | ±170.42% |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 181.232ms | ±19.30%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.549ms   | ±2.73%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.790ms   | ±17.95%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 5.972ms   | ±0.53%   |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.907ms   | ±0.58%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.852ms  | ±0.73%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.014ms  | ±0.59%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.506ms  | ±0.53%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.055ms  | ±1.58%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 757.142μs | ±1.26%   |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 841.541μs | ±20.82%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 892.635μs | ±7.01%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.480ms   | ±0.98%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.217ms   | ±0.82%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.143ms  | ±2.46%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.786ms  | ±0.47%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.725ms  | ±0.34%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 64.169ms  | ±1.31%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 102.831ms | ±0.31%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.239ms  | ±3.08%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.835ms  | ±0.27%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.390ms  | ±0.44%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 72.749ms  | ±0.31%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 159.470ms | ±0.69%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.030ms   | ±1.55%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.075ms  | ±0.73%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.142μs   | ±22.36%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.333μs   | ±15.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 192.743ms | ±16.24%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 452.329μs | ±2.25%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.988ms   | ±1.12%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.357ms   | ±0.72%   |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 12.455ms  | ±2.74%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 85.874ms  | ±0.46%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.603ms  | ±2.43%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 24.878ms  | ±1.36%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 185.750ms | ±22.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.432ms  | ±0.85%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.364ms  | ±0.44%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.466ms  | ±0.77%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.628ms  | ±0.74%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 13.855ms  | ±1.14%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.118ms   | ±26.95%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.448ms  | ±0.34%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.452ms  | ±0.35%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.158ms  | ±0.77%   |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.228ms   | ±0.25%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.665ms   | ±0.54%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.947ms   | ±0.57%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.020ms   | ±0.74%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.354ms   | ±0.88%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.990ms   | ±1.18%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.375ms   | ±0.91%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.746ms   | ±0.61%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 556.391μs | ±1.45%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.916ms   | ±0.95%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.931ms   | ±1.09%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.830ms   | ±0.98%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.735ms  | ±1.13%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.969ms   | ±0.82%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.506ms   | ±0.56%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.301ms   | ±0.39%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.436ms   | ±0.24%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.834ms   | ±0.14%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.224μs   | ±5.66%   |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.251ms   | ±0.81%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.623mb | 51.732ms  | ±0.48%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 15.211mb | 106.029ms | ±0.25%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.397mb | 1.263s    | ±0.76%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.820mb | 25.649ms  | ±1.44%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.846mb | 57.744ms  | ±0.54%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.592mb | 514.320ms | ±0.22%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.103mb | 62.932ms  | ±8.99%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.757mb | 83.968ms  | ±1.15%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.526mb | 728.894ms | ±0.25%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.868mb | 21.193ms  | ±0.16%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.868mb | 45.515ms  | ±0.19%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.510mb | 319.009ms | ±0.58%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 40.984μs  | ±1.65%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 241.919μs | ±2.12%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.319ms   | ±0.47%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.122ms  | ±0.48%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 46.761ms  | ±0.51%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.762ms   | ±0.51%   |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 9.954ms   | ±3.55%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.912mb | 77.614ms  | ±0.32%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.302mb | 334.655ms | ±0.33%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 43.922mb | 1.320s    | ±0.40%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.844mb | 234.889ms | ±0.90%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.149mb | 185.168ms | ±0.65%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.698mb | 147.274ms | ±0.26%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.734mb | 198.756ms | ±0.29%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 16.292mb | 163.387ms | ±0.08%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.770mb | 310.214ms | ±1.08%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 14.438mb | 47.440ms  | ±0.77%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 14.357mb | 41.426ms  | ±0.56%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 14.286mb | 39.293ms  | ±0.38%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 15.587mb | 130.244ms | ±0.40%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 14.346mb | 43.420ms  | ±0.70%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 14.558mb | 55.301ms  | ±0.46%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 14.975mb | 81.167ms  | ±0.52%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 14.253mb | 35.098ms  | ±0.23%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 14.501mb | 43.337ms  | ±0.24%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 14.284mb | 44.881ms  | ±0.36%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 14.356mb | 43.770ms  | ±0.20%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 14.274mb | 42.535ms  | ±0.26%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 29.820mb | 117.953ms | ±0.09%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 16.797mb | 41.505ms  | ±0.55%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 15.549mb | 36.858ms  | ±0.63%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.221mb | 40.015ms  | ±0.56%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.290mb | 45.002ms  | ±0.26%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.235mb | 44.424ms  | ±0.20%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 17.964mb | 40.596ms  | ±0.85%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.535mb | 206.174ms | ±0.35%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.817mb | 164.172ms | ±1.04%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.043ms   | ±0.33%   |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.647ms  | ±0.88%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.113ms  | ±0.79%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.264ms   | ±0.61%   |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.355ms   | ±7.53%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.303ms   | ±1.55%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.744ms   | ±0.86%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.867ms   | ±0.36%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.664ms   | ±0.64%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.144ms   | ±1.05%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.485ms   | ±0.71%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.380ms   | ±0.48%   |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.436ms   | ±0.65%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.651ms  | ±0.47%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.295ms   | ±1.66%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.593ms   | ±0.81%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.812ms   | ±0.13%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.791ms   | ±0.40%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.290ms   | ±0.25%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.055ms  | ±0.06%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.037ms  | ±1.20%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.634ms  | ±1.84%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.151ms  | ±0.28%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 40.995ms  | ±0.30%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 994.396μs | ±2.96%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.133ms   | ±3.20%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.203ms   | ±0.63%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.891ms   | ±0.93%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.773ms   | ±1.15%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```