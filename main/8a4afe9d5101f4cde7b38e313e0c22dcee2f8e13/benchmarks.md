# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-27 06:33:25 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 7.586ms | 1.538ms | 1.650ms | 2.790ms | 4.049ms |
| FPDF | 540.050μs | 573.126μs | 1.039ms | 973.890μs | 1.351ms |
| TCPDF | 6.922ms | 7.055ms | 7.393ms | 11.648ms | 17.179ms |
| mPDF | 16.198ms | 18.248ms | 20.351ms | 37.280ms | 57.925ms |
| Dompdf | 6.815ms | 9.378ms | 12.131ms | 39.921ms | 87.126ms |

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
| phpdftk | 2.038ms | 2.166ms | 2.405ms | 3.599ms | 4.819ms |
| FPDF | 723.466μs | 752.027μs | 823.073μs | 1.202ms | 1.672ms |
| TCPDF | 11.150ms | 11.371ms | 11.925ms | 16.996ms | 23.464ms |

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
| Pdf (Level 3) | 2.053ms | 2.707ms | 6.780ms |
| PdfDoc (Level 2) | 1.660ms | 1.918ms | 4.240ms |
| PdfWriter (Level 1) | 1.471ms | 1.655ms | 3.994ms |

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
| Pdf (Level 3) | 2.677ms | 6.955ms | 25.632ms |
| PdfDoc (Level 2) | 2.233ms | 5.614ms | — |

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
| Pdf (Level 3) | 2.521ms | 6.731ms | 24.661ms |
| PdfDoc (Level 2) | 2.075ms | 4.112ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 3.264ms | 991.769μs | 3.071ms |
| smalot/pdfparser | 1.233ms | 1.451ms | 3.209ms |
| setasign/fpdi | 1.131ms | 1.568ms | 14.574ms |

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
| phpdftk | 1.119ms | 830.462μs |
| smalot/pdfparser | FAIL | 1.220ms |
| setasign/fpdi | 1.666ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 6.105ms   | ±1.53%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 6.045ms   | ±1.30%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 6.891ms   | ±22.27%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 6.655ms   | ±1.89%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 6.232ms   | ±0.84%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 5.952ms   | ±0.85%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 10.359ms  | ±1.20%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 1.799ms   | ±0.96%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 2.521ms   | ±126.07% |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 6.731ms   | ±2.64%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 24.661ms  | ±0.97%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 2.075ms   | ±157.06% |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 4.112ms   | ±0.96%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.624μs   | ±10.88%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.921μs   | ±38.22%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.212mb | 9.059ms   | ±1.83%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.212mb | 9.146ms   | ±0.86%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.014mb | 29.739ms  | ±1.86%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.605mb | 57.155ms  | ±0.98%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.261mb | 687.609ms | ±3.41%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.182mb | 15.542ms  | ±6.99%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.208mb | 32.567ms  | ±1.09%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.019mb | 324.664ms | ±1.58%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.466mb | 37.208ms  | ±11.61%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.185mb | 48.104ms  | ±2.31%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.954mb | 401.467ms | ±0.52%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.230mb | 10.985ms  | ±1.22%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.230mb | 24.893ms  | ±1.07%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.873mb | 168.451ms | ±1.28%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 2.677ms   | ±2.64%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 6.955ms   | ±21.20%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 25.632ms  | ±1.60%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 2.233ms   | ±2.78%   |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 5.614ms   | ±0.50%   |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 736.279μs | ±3.13%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 991.769μs | ±2.51%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 3.071ms   | ±0.95%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 1.119ms   | ±2.27%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 830.462μs | ±2.57%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.233ms   | ±0.30%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 1.451ms   | ±1.10%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 3.209ms   | ±2.60%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 374.126μs | ±4.29%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.220ms   | ±2.62%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.131ms   | ±1.27%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 1.568ms   | ±2.88%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 14.574ms  | ±0.96%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 1.666ms   | ±3.29%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 985.187μs | ±3.30%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 4.154ms   | ±0.64%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 3.258ms   | ±0.97%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 2.364ms   | ±2.23%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.121μs   | ±25.71%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 3.264ms   | ±2.54%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 12.719ms  | ±0.25%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 114.003ms | ±0.45%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 571.948ms | ±0.85%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 1.471ms   | ±78.47%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 1.655ms   | ±1.73%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 3.994ms   | ±3.22%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 1.660ms   | ±2.09%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 1.918ms   | ±5.17%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 4.240ms   | ±0.82%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 2.053ms   | ±1.31%   |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 2.707ms   | ±36.46%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 6.780ms   | ±5.25%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 1.444ms   | ±2.84%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 1.538ms   | ±4.76%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 1.650ms   | ±0.60%   |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 2.790ms   | ±1.21%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 4.049ms   | ±1.77%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 2.215ms   | ±21.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 2.269ms   | ±0.46%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 7.028ms   | ±25.45%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 2.213ms   | ±1.36%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 1.430ms   | ±0.70%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 450.353μs | ±118.04% |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 1.971ms   | ±0.83%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 2.185ms   | ±80.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 1.923ms   | ±1.41%   |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 139.960ms | ±28.32%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 2.175ms   | ±41.13%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 3.444ms   | ±25.22%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 3.477ms   | ±1.89%   |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 6.922ms   | ±13.60%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 7.055ms   | ±2.77%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 7.393ms   | ±0.62%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 11.648ms  | ±3.83%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 17.179ms  | ±2.12%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 540.050μs | ±78.16%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 573.126μs | ±12.52%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 1.039ms   | ±78.92%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 973.890μs | ±129.62% |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 1.351ms   | ±0.97%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 16.198ms  | ±1.83%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 18.248ms  | ±2.71%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 20.351ms  | ±2.69%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 37.280ms  | ±0.99%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 57.925ms  | ±1.01%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 6.815ms   | ±0.69%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 9.378ms   | ±0.78%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 12.131ms  | ±2.93%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 39.921ms  | ±1.35%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 87.126ms  | ±0.87%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 2.875ms   | ±38.55%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 27.576ms  | ±43.98%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.483μs   | ±30.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.333μs   | ±15.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.322μs   | ±13.61%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 101.741ms | ±22.67%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 268.494μs | ±2.32%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 1.665ms   | ±1.56%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 2.099ms   | ±6.60%   |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 6.559ms   | ±3.36%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 51.744ms  | ±2.26%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 7.253ms   | ±1.39%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 12.468ms  | ±0.95%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 107.165ms | ±16.39%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 7.547ms   | ±1.29%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 7.622ms   | ±2.25%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 7.635ms   | ±1.86%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 7.776ms   | ±1.98%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 7.740ms   | ±5.03%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 2.196ms   | ±8.36%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 7.605ms   | ±1.55%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 7.468ms   | ±1.61%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 7.586ms   | ±0.86%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 2.038ms   | ±1.51%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 2.166ms   | ±1.34%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 2.405ms   | ±25.56%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 3.599ms   | ±23.59%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 4.819ms   | ±1.06%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 11.150ms  | ±1.86%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 11.371ms  | ±0.95%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 11.925ms  | ±1.02%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 16.996ms  | ±3.80%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 23.464ms  | ±2.24%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 723.466μs | ±1.66%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 752.027μs | ±2.70%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 823.073μs | ±1.82%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.202ms   | ±0.61%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 1.672ms   | ±2.05%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 22.573μs  | ±5.00%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 131.974μs | ±0.63%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.305mb | 41.979ms  | ±0.34%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.140mb | 179.802ms | ±0.42%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.803mb | 706.073ms | ±0.40%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.332mb | 134.420ms | ±1.29%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.915mb | 103.076ms | ±1.82%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.089mb | 81.899ms  | ±1.49%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.140mb | 107.904ms | ±0.36%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.689mb | 89.613ms  | ±0.10%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.184mb | 169.994ms | ±0.52%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.763mb | 26.844ms  | ±1.15%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.748mb | 23.642ms  | ±1.17%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.676mb | 22.904ms  | ±1.76%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.912mb | 70.889ms  | ±0.59%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.671mb | 24.727ms  | ±1.00%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.948mb | 30.206ms  | ±1.55%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.365mb | 44.368ms  | ±1.08%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.643mb | 19.993ms  | ±3.43%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.581mb | 25.163ms  | ±1.52%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.608mb | 25.461ms  | ±0.88%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.577mb | 25.073ms  | ±0.63%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.599mb | 24.425ms  | ±1.71%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.567mb | 38.711ms  | ±1.07%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.620mb | 24.720ms  | ±2.52%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.297mb | 21.337ms  | ±3.69%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.545mb | 22.634ms  | ±2.16%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.566mb | 26.359ms  | ±1.61%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.559mb | 25.395ms  | ±2.26%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.788mb | 24.413ms  | ±1.86%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.931mb | 115.841ms | ±6.89%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.209mb | 88.491ms  | ±1.36%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 4.992ms   | ±2.38%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 4.805ms   | ±2.24%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 4.841ms   | ±1.01%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```