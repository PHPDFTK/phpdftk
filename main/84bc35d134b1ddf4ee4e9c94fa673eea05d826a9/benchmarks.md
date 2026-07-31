# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-31 08:39:45 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.802ms | 2.506ms | 2.753ms | 4.814ms | 7.066ms |
| FPDF | 802.164μs | 862.634μs | 939.539μs | 1.530ms | 2.251ms |
| TCPDF | 10.253ms | 10.972ms | 12.008ms | 19.152ms | 28.409ms |
| mPDF | 25.848ms | 29.098ms | 32.791ms | 60.407ms | 95.092ms |
| Dompdf | 11.279ms | 15.370ms | 20.118ms | 66.861ms | 149.305ms |

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
| phpdftk | 3.374ms | 3.603ms | 3.832ms | 5.846ms | 8.359ms |
| FPDF | 1.059ms | 1.132ms | 1.247ms | 1.944ms | 2.802ms |
| TCPDF | 17.363ms | 18.268ms | 19.638ms | 27.854ms | 38.317ms |

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
| Pdf (Level 3) | 3.441ms | 4.441ms | 12.216ms |
| PdfDoc (Level 2) | 2.715ms | 3.177ms | 7.598ms |
| PdfWriter (Level 1) | 2.311ms | 2.778ms | 6.941ms |

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
| Pdf (Level 3) | 4.416ms | 12.032ms | 46.541ms |
| PdfDoc (Level 2) | 3.789ms | 10.115ms | — |

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
| Pdf (Level 3) | 4.061ms | 11.532ms | 44.670ms |
| PdfDoc (Level 2) | 3.291ms | 7.295ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.154ms | 1.686ms | 6.123ms |
| smalot/pdfparser | 2.055ms | 2.375ms | 5.551ms |
| setasign/fpdi | 1.922ms | 2.728ms | 28.479ms |

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
| phpdftk | 2.063ms | 1.366ms |
| smalot/pdfparser | FAIL | 1.982ms |
| setasign/fpdi | 2.886ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 8.879ms   | ±0.68%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.320ms   | ±0.56%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.371ms   | ±0.32%   |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.215mb  | 9.460ms   | ±0.09%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.087mb  | 9.742ms   | ±0.40%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.913mb  | 11.384ms  | ±1.64%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.957mb  | 11.188ms  | ±0.77%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.376mb  | 10.764ms  | ±0.51%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.514mb  | 9.715ms   | ±0.98%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.756mb | 17.564ms  | ±0.47%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.731mb  | 2.962ms   | ±0.55%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.279mb  | 22.840ms  | ±0.84%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.264mb | 203.410ms | ±1.31%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.780mb | 976.506ms | ±1.63%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.176μs   | ±21.28%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.208μs   | ±30.21%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.946mb | 15.072ms  | ±0.60%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.946mb | 14.811ms  | ±0.15%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.301ms   | ±1.13%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.506ms   | ±0.93%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.753ms   | ±0.73%   |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.814ms   | ±1.16%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.066ms   | ±0.91%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.567ms   | ±0.43%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.838ms   | ±1.56%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.834ms  | ±1.41%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.584ms   | ±1.23%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.365ms   | ±0.50%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 772.978μs | ±188.31% |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.144ms   | ±3.43%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.556ms   | ±0.54%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.169ms   | ±0.44%   |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 251.507ms | ±21.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.598ms   | ±1.06%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.845ms   | ±20.23%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.043ms   | ±1.01%   |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.253ms  | ±58.50%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.972ms  | ±0.45%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.008ms  | ±0.80%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 19.152ms  | ±0.67%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 28.409ms  | ±0.69%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 802.164μs | ±1.85%   |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 862.634μs | ±3.02%   |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 939.539μs | ±1.53%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.530ms   | ±1.59%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.251ms   | ±0.53%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.848ms  | ±2.28%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.098ms  | ±0.29%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.791ms  | ±0.55%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 60.407ms  | ±0.38%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 95.092ms  | ±0.38%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.279ms  | ±2.17%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.370ms  | ±0.29%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 20.118ms  | ±0.35%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 66.861ms  | ±0.60%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 149.305ms | ±0.75%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.044ms   | ±0.73%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 52.700ms  | ±1.16%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.667μs   | ±7.69%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±7.69%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 252.661ms | ±8.38%   |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 493.797μs | ±1.40%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.939ms   | ±0.18%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.393ms   | ±0.67%   |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 11.307ms  | ±6.87%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 81.722ms  | ±1.16%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 15.732ms  | ±1.58%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.823ms  | ±0.63%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 246.096ms | ±22.56%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.872ms  | ±0.72%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.863ms  | ±0.33%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.891ms  | ±0.87%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.974ms  | ±1.11%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.357ms  | ±0.93%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.139ms   | ±0.78%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.993ms  | ±0.58%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 14.012ms  | ±2.29%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.802ms  | ±0.91%   |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.248ms   | ±1.47%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.686ms   | ±0.82%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.123ms   | ±0.52%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.063ms   | ±32.01%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.366ms   | ±1.24%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.055ms   | ±1.13%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.375ms   | ±0.53%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.551ms   | ±0.25%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 560.482μs | ±0.28%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.982ms   | ±1.91%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.922ms   | ±0.95%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.728ms   | ±0.69%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 28.479ms  | ±1.34%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.886ms   | ±1.00%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.488ms   | ±1.27%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.242ms   | ±0.67%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.427ms   | ±0.43%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.875ms   | ±0.56%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 4.200μs   | ±3.89%   |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.154ms   | ±0.59%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.682mb | 50.512ms  | ±0.95%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 15.270mb | 100.972ms | ±0.16%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.418mb | 1.192s    | ±0.49%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.828mb | 26.169ms  | ±2.11%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.854mb | 53.881ms  | ±1.51%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.599mb | 508.134ms | ±0.43%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.111mb | 66.258ms  | ±9.37%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.765mb | 84.682ms  | ±1.09%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.534mb | 676.529ms | ±1.59%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.876mb | 21.319ms  | ±1.08%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.876mb | 45.196ms  | ±0.30%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.518mb | 284.708ms | ±2.10%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 42.714μs  | ±0.91%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 239.795μs | ±1.23%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.416ms   | ±0.47%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.032ms  | ±1.74%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 46.541ms  | ±2.11%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.789ms   | ±0.71%   |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.115ms  | ±0.79%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.971mb | 74.543ms  | ±1.34%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.388mb | 312.564ms | ±0.19%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.008mb | 1.233s    | ±0.10%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.865mb | 224.943ms | ±0.36%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.169mb | 183.142ms | ±1.06%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.757mb | 142.314ms | ±0.59%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.793mb | 189.893ms | ±0.38%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 16.351mb | 152.589ms | ±0.48%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.829mb | 297.373ms | ±0.71%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 14.497mb | 44.979ms  | ±0.13%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 14.417mb | 39.399ms  | ±0.88%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 14.346mb | 37.892ms  | ±0.39%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 15.647mb | 123.451ms | ±0.64%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 14.405mb | 41.512ms  | ±0.39%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 14.617mb | 52.446ms  | ±0.68%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 15.034mb | 76.731ms  | ±0.68%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 14.312mb | 34.446ms  | ±1.15%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 14.522mb | 41.690ms  | ±0.82%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 14.343mb | 44.094ms  | ±0.70%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 14.377mb | 42.968ms  | ±0.89%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 14.333mb | 40.955ms  | ±1.15%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 29.840mb | 119.214ms | ±1.30%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 16.817mb | 41.476ms  | ±0.46%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 15.570mb | 35.823ms  | ±0.37%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.280mb | 38.941ms  | ±0.73%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.310mb | 44.664ms  | ±5.17%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.294mb | 43.058ms  | ±1.12%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 17.985mb | 40.243ms  | ±0.34%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.594mb | 193.499ms | ±0.30%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.876mb | 159.206ms | ±0.91%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.061ms   | ±1.38%   |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.532ms  | ±0.51%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 44.670ms  | ±0.72%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.291ms   | ±0.52%   |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.295ms   | ±2.47%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.311ms   | ±1.25%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.778ms   | ±0.92%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.941ms   | ±0.43%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.715ms   | ±0.95%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.177ms   | ±1.06%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.598ms   | ±1.01%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.441ms   | ±1.67%   |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.441ms   | ±0.91%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.216ms  | ±0.95%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.374ms   | ±0.63%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.603ms   | ±1.25%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.832ms   | ±0.53%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.846ms   | ±0.83%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.359ms   | ±1.02%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.363ms  | ±1.74%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.268ms  | ±1.85%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.638ms  | ±1.14%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 27.854ms  | ±0.39%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 38.317ms  | ±0.43%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.059ms   | ±2.27%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.132ms   | ±0.51%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.247ms   | ±6.00%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.944ms   | ±1.17%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.802ms   | ±0.69%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```