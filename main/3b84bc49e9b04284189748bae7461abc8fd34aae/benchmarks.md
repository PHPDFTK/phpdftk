# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-27 08:02:59 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.439ms | 2.536ms | 2.802ms | 4.882ms | 7.158ms |
| FPDF | 813.205μs | 865.763μs | 960.299μs | 1.516ms | 2.284ms |
| TCPDF | 10.163ms | 11.366ms | 12.527ms | 20.821ms | 31.803ms |
| mPDF | 25.560ms | 29.771ms | 33.652ms | 66.200ms | 106.296ms |
| Dompdf | 11.526ms | 16.463ms | 22.061ms | 74.839ms | 164.234ms |

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
| phpdftk | 3.467ms | 3.726ms | 4.032ms | 5.988ms | 8.579ms |
| FPDF | 1.087ms | 1.203ms | 1.280ms | 1.951ms | 2.838ms |
| TCPDF | 18.069ms | 18.817ms | 19.946ms | 30.366ms | 42.253ms |

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
| Pdf (Level 3) | 3.409ms | 4.491ms | 12.785ms |
| PdfDoc (Level 2) | 2.738ms | 3.248ms | 7.559ms |
| PdfWriter (Level 1) | 2.363ms | 2.795ms | 6.923ms |

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
| Pdf (Level 3) | 4.484ms | 12.239ms | 47.294ms |
| PdfDoc (Level 2) | 3.786ms | 10.182ms | — |

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
| Pdf (Level 3) | 4.154ms | 11.738ms | 46.034ms |
| PdfDoc (Level 2) | 3.338ms | 7.422ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.441ms | 1.698ms | 6.042ms |
| smalot/pdfparser | 2.031ms | 2.416ms | 5.836ms |
| setasign/fpdi | 1.976ms | 2.863ms | 29.841ms |

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
| phpdftk | 2.064ms | 1.379ms |
| smalot/pdfparser | FAIL | 1.949ms |
| setasign/fpdi | 3.033ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 10.410ms  | ±9.25%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 10.400ms  | ±4.53%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 12.290ms  | ±4.12%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 12.122ms  | ±1.34%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 11.306ms  | ±0.84%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 10.549ms  | ±3.56%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 19.742ms  | ±0.31%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 3.141ms   | ±11.92% |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.154ms   | ±0.76%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.738ms  | ±10.16% |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 46.034ms  | ±0.49%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.338ms   | ±5.52%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.422ms   | ±7.37%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.966μs   | ±19.64% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.986μs   | ±26.50% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.212mb | 16.596ms  | ±1.60%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.212mb | 16.288ms  | ±0.39%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.015mb | 56.309ms  | ±1.41%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.606mb | 112.121ms | ±0.32%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.262mb | 1.368s    | ±0.84%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.182mb | 26.118ms  | ±2.05%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.208mb | 58.647ms  | ±1.21%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.019mb | 550.943ms | ±1.16%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.466mb | 65.292ms  | ±10.45% |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.185mb | 87.183ms  | ±0.99%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.954mb | 740.718ms | ±0.50%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.230mb | 19.221ms  | ±1.33%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.230mb | 44.360ms  | ±1.19%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.873mb | 328.760ms | ±0.92%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.484ms   | ±12.45% |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.239ms  | ±1.13%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.294ms  | ±0.49%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.786ms   | ±1.40%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.182ms  | ±0.83%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.265ms   | ±0.92%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.698ms   | ±0.66%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.042ms   | ±1.26%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.064ms   | ±0.67%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.379ms   | ±1.29%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.031ms   | ±0.85%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.416ms   | ±0.59%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.836ms   | ±1.66%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 558.298μs | ±2.91%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.949ms   | ±0.70%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.976ms   | ±0.75%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.863ms   | ±1.21%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.841ms  | ±1.15%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.033ms   | ±0.52%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.540ms   | ±2.16%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.355ms   | ±0.40%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.482ms   | ±1.11%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.898ms   | ±0.61%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.761μs   | ±25.98% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.441ms   | ±1.24%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 25.352ms  | ±1.15%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 230.459ms | ±1.69%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 1.139s    | ±0.54%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.363ms   | ±0.41%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.795ms   | ±0.63%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.923ms   | ±1.42%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.738ms   | ±1.18%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.248ms   | ±1.40%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.559ms   | ±0.67%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.409ms   | ±9.62%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.491ms   | ±1.41%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.785ms  | ±0.39%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.332ms   | ±0.53%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.536ms   | ±1.74%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.802ms   | ±1.36%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.882ms   | ±1.11%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.158ms   | ±1.09%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.670ms   | ±0.55%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.962ms   | ±0.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.459ms  | ±0.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.795ms   | ±1.45%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.481ms   | ±1.65%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 674.905μs | ±3.52%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.296ms   | ±1.07%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.750ms   | ±1.05%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.357ms   | ±0.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 208.602ms | ±6.06%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.673ms   | ±0.60%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 6.006ms   | ±1.54%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.215ms   | ±1.24%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.163ms  | ±1.00%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.366ms  | ±0.84%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.527ms  | ±1.03%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.821ms  | ±0.63%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.803ms  | ±0.90%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 813.205μs | ±2.79%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 865.763μs | ±4.87%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 960.299μs | ±0.71%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.516ms   | ±0.64%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.284ms   | ±0.40%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.560ms  | ±1.21%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.771ms  | ±0.89%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.652ms  | ±1.25%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 66.200ms  | ±2.48%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 106.296ms | ±0.89%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.526ms  | ±1.48%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.463ms  | ±0.78%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 22.061ms  | ±0.81%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 74.839ms  | ±0.78%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 164.234ms | ±0.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.195ms   | ±0.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.495ms  | ±1.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 207.586ms | ±11.12% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 473.801μs | ±1.97%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.047ms   | ±0.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.547ms   | ±1.13%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 13.860ms  | ±6.78%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 86.453ms  | ±0.81%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.287ms  | ±3.33%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 24.806ms  | ±2.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 269.698ms | ±29.16% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.738ms  | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.714ms  | ±0.41%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.831ms  | ±1.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.946ms  | ±0.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.138ms  | ±1.04%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.253ms   | ±1.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.722ms  | ±0.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.640ms  | ±0.82%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.439ms  | ±0.72%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.467ms   | ±1.00%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.726ms   | ±1.17%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 4.032ms   | ±0.49%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.988ms   | ±0.30%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.579ms   | ±0.34%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 18.069ms  | ±1.90%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.817ms  | ±0.76%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.946ms  | ±1.15%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 30.366ms  | ±1.03%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 42.253ms  | ±0.70%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.087ms   | ±2.21%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.203ms   | ±1.63%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.280ms   | ±0.33%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.951ms   | ±1.80%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.838ms   | ±1.45%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.523μs  | ±0.75%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 245.429μs | ±3.03%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.305mb | 84.517ms  | ±2.88%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.140mb | 361.725ms | ±0.37%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.803mb | 1.431s    | ±0.42%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.332mb | 253.170ms | ±0.87%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.916mb | 196.586ms | ±0.65%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.090mb | 161.643ms | ±1.28%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.141mb | 217.096ms | ±1.56%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.690mb | 179.789ms | ±0.76%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.185mb | 339.082ms | ±0.19%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.763mb | 52.107ms  | ±0.32%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.748mb | 45.282ms  | ±0.73%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.677mb | 42.412ms  | ±0.83%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.913mb | 139.566ms | ±1.58%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.672mb | 47.311ms  | ±0.32%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.949mb | 59.839ms  | ±0.54%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.365mb | 87.915ms  | ±0.66%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.644mb | 38.427ms  | ±5.27%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.581mb | 46.792ms  | ±0.70%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.609mb | 48.276ms  | ±0.30%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.577mb | 47.587ms  | ±0.46%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.600mb | 45.606ms  | ±0.38%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.568mb | 72.441ms  | ±0.75%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.621mb | 44.811ms  | ±0.29%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.297mb | 39.684ms  | ±0.74%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.546mb | 43.070ms  | ±0.54%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.567mb | 48.626ms  | ±0.42%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.560mb | 47.631ms  | ±1.26%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.788mb | 43.745ms  | ±0.43%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.932mb | 223.346ms | ±0.64%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.209mb | 171.925ms | ±0.77%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.025ms   | ±1.03%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.603ms   | ±1.07%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.711ms   | ±0.46%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```