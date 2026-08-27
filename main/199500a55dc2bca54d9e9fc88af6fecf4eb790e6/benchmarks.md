# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-27 07:14:34 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 8.437ms | 1.761ms | 1.969ms | 3.593ms | 5.265ms |
| FPDF | 590.943μs | 581.010μs | 630.721μs | 1.206ms | 1.581ms |
| TCPDF | 7.435ms | 8.081ms | 8.702ms | 18.572ms | 20.485ms |
| mPDF | 17.858ms | 20.302ms | 22.455ms | 40.109ms | 61.918ms |
| Dompdf | 7.729ms | 11.369ms | 13.649ms | 43.149ms | 96.629ms |

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
| phpdftk | 2.065ms | 3.153ms | 2.394ms | 4.029ms | 5.480ms |
| FPDF | 1.022ms | 806.205μs | 837.752μs | 1.336ms | 1.903ms |
| TCPDF | 12.477ms | 12.925ms | 13.800ms | 19.978ms | 27.447ms |

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
| Pdf (Level 3) | 2.424ms | 3.328ms | 8.844ms |
| PdfDoc (Level 2) | 1.987ms | 2.271ms | 5.750ms |
| PdfWriter (Level 1) | 1.818ms | 1.938ms | 5.284ms |

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
| Pdf (Level 3) | 2.875ms | 7.887ms | 29.509ms |
| PdfDoc (Level 2) | 2.392ms | 6.453ms | — |

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
| Pdf (Level 3) | 2.750ms | 7.014ms | 26.310ms |
| PdfDoc (Level 2) | 3.583ms | 4.602ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 3.441ms | 961.134μs | 3.281ms |
| smalot/pdfparser | 1.322ms | 1.535ms | 3.671ms |
| setasign/fpdi | 1.217ms | 1.697ms | 16.236ms |

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
| phpdftk | 1.146ms | 803.251μs |
| smalot/pdfparser | FAIL | 1.270ms |
| setasign/fpdi | 1.807ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 7.009ms   | ±1.06%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 6.636ms   | ±1.63%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 7.539ms   | ±1.05%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 7.514ms   | ±2.19%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 6.866ms   | ±0.96%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 6.641ms   | ±2.49%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 12.115ms  | ±0.89%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 1.903ms   | ±0.88%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 2.750ms   | ±157.32% |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 7.014ms   | ±1.31%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 26.310ms  | ±29.66%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.583ms   | ±107.71% |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 4.602ms   | ±20.69%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 0.849μs   | ±35.36%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 0.873μs   | ±47.14%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.212mb | 10.484ms  | ±1.37%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.212mb | 10.285ms  | ±1.73%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.015mb | 40.651ms  | ±48.21%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.606mb | 61.092ms  | ±0.14%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.262mb | 724.972ms | ±0.57%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.182mb | 16.324ms  | ±2.97%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.208mb | 34.681ms  | ±1.08%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.019mb | 303.933ms | ±0.59%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.466mb | 45.972ms  | ±4.82%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.185mb | 58.958ms  | ±1.72%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.954mb | 503.029ms | ±0.47%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.230mb | 14.371ms  | ±1.56%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.230mb | 30.717ms  | ±0.61%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.873mb | 204.837ms | ±4.51%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 2.875ms   | ±48.11%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 7.887ms   | ±0.68%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 29.509ms  | ±32.45%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 2.392ms   | ±1.63%   |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 6.453ms   | ±54.59%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 747.783μs | ±1.73%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 961.134μs | ±0.55%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 3.281ms   | ±0.77%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 1.146ms   | ±1.96%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 803.251μs | ±0.55%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.322ms   | ±1.70%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 1.535ms   | ±1.35%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 3.671ms   | ±1.11%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 377.734μs | ±2.30%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.270ms   | ±2.94%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.217ms   | ±2.71%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 1.697ms   | ±1.18%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 16.236ms  | ±0.21%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 1.807ms   | ±1.39%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 983.293μs | ±0.72%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 4.363ms   | ±1.38%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 3.344ms   | ±0.61%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 2.425ms   | ±0.23%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 1.673μs   | ±28.28%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 3.441ms   | ±0.80%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 13.707ms  | ±0.46%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 121.499ms | ±0.42%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 610.948ms | ±0.17%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 1.818ms   | ±114.69% |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 1.938ms   | ±12.26%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 5.284ms   | ±83.67%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 1.987ms   | ±95.76%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 2.271ms   | ±7.72%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 5.750ms   | ±6.39%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 2.424ms   | ±89.12%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 3.328ms   | ±0.72%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 8.844ms   | ±71.77%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 1.680ms   | ±60.40%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 1.761ms   | ±0.70%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 1.969ms   | ±25.93%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 3.593ms   | ±1.58%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 5.265ms   | ±1.85%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 2.475ms   | ±6.44%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 2.627ms   | ±125.08% |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 7.825ms   | ±1.65%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 2.428ms   | ±1.31%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 1.502ms   | ±2.68%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 397.442μs | ±14.35%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.706ms   | ±46.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 2.744ms   | ±56.84%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 2.174ms   | ±45.94%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 146.843ms | ±23.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 2.448ms   | ±85.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.453ms   | ±89.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 4.286ms   | ±6.30%   |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 7.435ms   | ±5.58%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 8.081ms   | ±0.98%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 8.702ms   | ±1.15%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 18.572ms  | ±84.64%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 20.485ms  | ±0.63%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 590.943μs | ±115.21% |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 581.010μs | ±4.09%   |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 630.721μs | ±1.40%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.206ms   | ±55.21%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 1.581ms   | ±47.68%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 17.858ms  | ±2.19%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 20.302ms  | ±0.40%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 22.455ms  | ±1.22%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 40.109ms  | ±6.14%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 61.918ms  | ±0.19%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 7.729ms   | ±2.01%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 11.369ms  | ±41.29%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 13.649ms  | ±1.37%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 43.149ms  | ±0.51%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 96.629ms  | ±0.28%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 3.272ms   | ±1.47%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 29.852ms  | ±1.66%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 0.667μs   | ±0.00%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 0.678μs   | ±20.41%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 0.666μs   | ±22.22%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 103.722ms | ±17.70%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 275.149μs | ±1.13%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 1.929ms   | ±0.71%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 2.234ms   | ±21.12%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 10.070ms  | ±29.39%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 48.140ms  | ±0.18%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 8.092ms   | ±0.74%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 14.484ms  | ±0.43%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 107.268ms | ±39.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 8.451ms   | ±0.83%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 8.512ms   | ±1.59%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 8.519ms   | ±0.77%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 8.581ms   | ±1.12%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 8.517ms   | ±1.21%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 2.158ms   | ±2.29%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 8.570ms   | ±0.38%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 8.510ms   | ±46.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 8.437ms   | ±0.58%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 2.065ms   | ±1.83%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.153ms   | ±99.47%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 2.394ms   | ±0.75%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 4.029ms   | ±45.04%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 5.480ms   | ±0.56%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 12.477ms  | ±1.03%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 12.925ms  | ±1.73%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 13.800ms  | ±0.93%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 19.978ms  | ±0.52%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 27.447ms  | ±0.83%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.022ms   | ±93.21%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 806.205μs | ±3.37%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 837.752μs | ±0.39%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.336ms   | ±1.82%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 1.903ms   | ±0.43%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 23.785μs  | ±1.32%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 155.361μs | ±1.84%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.305mb | 46.401ms  | ±9.00%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.140mb | 214.092ms | ±0.54%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.803mb | 763.241ms | ±3.51%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.332mb | 134.962ms | ±0.24%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.916mb | 108.762ms | ±0.26%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.090mb | 84.646ms  | ±0.15%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.141mb | 114.327ms | ±0.28%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.689mb | 94.719ms  | ±0.03%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.185mb | 178.226ms | ±0.24%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.763mb | 28.355ms  | ±0.38%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.748mb | 24.874ms  | ±0.11%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.677mb | 24.063ms  | ±0.25%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.912mb | 75.453ms  | ±0.71%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.671mb | 26.058ms  | ±0.30%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.948mb | 32.425ms  | ±0.29%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.365mb | 47.294ms  | ±0.05%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.644mb | 21.425ms  | ±0.03%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.581mb | 25.718ms  | ±0.21%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.609mb | 27.035ms  | ±0.20%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.577mb | 26.373ms  | ±0.18%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.599mb | 25.676ms  | ±0.37%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.568mb | 41.792ms  | ±0.47%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.621mb | 25.650ms  | ±0.16%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.297mb | 22.738ms  | ±0.58%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.546mb | 24.265ms  | ±0.28%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.567mb | 27.155ms  | ±0.50%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.560mb | 26.821ms  | ±0.05%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.788mb | 25.087ms  | ±0.20%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.932mb | 120.412ms | ±0.24%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.209mb | 95.503ms  | ±0.15%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 5.509ms   | ±27.72%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 5.294ms   | ±1.39%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 5.327ms   | ±0.93%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```