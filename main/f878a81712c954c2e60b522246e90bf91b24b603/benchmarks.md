# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-28 20:17:22 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 11.381ms | 2.235ms | 2.499ms | 4.476ms | 6.534ms |
| FPDF | 844.194μs | 822.873μs | 896.080μs | 1.506ms | 2.277ms |
| TCPDF | 10.100ms | 11.074ms | 11.993ms | 19.515ms | 29.049ms |
| mPDF | 24.576ms | 27.632ms | 31.021ms | 56.335ms | 88.151ms |
| Dompdf | 10.765ms | 14.643ms | 19.202ms | 61.169ms | 135.306ms |

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
| phpdftk | 2.978ms | 3.173ms | 3.404ms | 5.319ms | 7.810ms |
| FPDF | 1.044ms | 1.122ms | 1.244ms | 1.922ms | 2.759ms |
| TCPDF | 16.673ms | 17.720ms | 18.730ms | 27.219ms | 38.369ms |

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
| Pdf (Level 3) | 3.072ms | 4.107ms | 11.076ms |
| PdfDoc (Level 2) | 2.450ms | 2.879ms | 7.010ms |
| PdfWriter (Level 1) | 2.147ms | 2.499ms | 6.436ms |

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
| Pdf (Level 3) | 4.039ms | 10.812ms | 40.467ms |
| PdfDoc (Level 2) | 3.435ms | 9.858ms | — |

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
| Pdf (Level 3) | 3.640ms | 9.933ms | 36.797ms |
| PdfDoc (Level 2) | 2.944ms | 6.422ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 4.903ms | 1.398ms | 4.775ms |
| smalot/pdfparser | 1.900ms | 2.222ms | 5.242ms |
| setasign/fpdi | 1.732ms | 2.431ms | 23.522ms |

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
| phpdftk | 1.680ms | 1.173ms |
| smalot/pdfparser | FAIL | 1.793ms |
| setasign/fpdi | 2.581ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 9.429ms   | ±0.83%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 9.691ms   | ±10.88%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 10.691ms  | ±1.07%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 10.879ms  | ±0.59%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 10.095ms  | ±0.42%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 9.706ms   | ±0.60%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 17.137ms  | ±0.27%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 2.756ms   | ±1.01%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 3.640ms   | ±43.20%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 9.933ms   | ±0.88%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 36.797ms  | ±12.54%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 2.944ms   | ±0.67%   |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 6.422ms   | ±30.56%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.166μs   | ±30.86%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.109μs   | ±53.03%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.221mb | 14.538ms  | ±0.24%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.221mb | 14.554ms  | ±0.32%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.024mb | 44.544ms  | ±0.54%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.615mb | 89.236ms  | ±0.19%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.271mb | 1.057s    | ±0.55%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.191mb | 23.830ms  | ±4.71%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.217mb | 49.784ms  | ±1.08%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.028mb | 436.748ms | ±0.62%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.475mb | 57.890ms  | ±8.87%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.194mb | 75.069ms  | ±1.15%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.963mb | 634.879ms | ±1.48%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.239mb | 24.141ms  | ±37.30%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.239mb | 68.702ms  | ±32.76%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.882mb | 274.473ms | ±0.05%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.039ms   | ±0.56%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 10.812ms  | ±45.78%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 40.467ms  | ±0.32%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.435ms   | ±51.11%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 9.858ms   | ±46.58%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.059ms   | ±1.37%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.398ms   | ±0.95%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 4.775ms   | ±1.03%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 1.680ms   | ±1.55%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.173ms   | ±0.60%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.900ms   | ±0.76%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.222ms   | ±0.63%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.242ms   | ±0.97%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 537.483μs | ±1.75%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.793ms   | ±1.01%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.732ms   | ±0.75%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.431ms   | ±0.20%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 23.522ms  | ±0.48%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.581ms   | ±1.74%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.413ms   | ±1.29%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 6.215ms   | ±1.39%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 4.756ms   | ±0.60%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.459ms   | ±0.86%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 2.085μs   | ±26.76%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 4.903ms   | ±0.50%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 20.420ms  | ±1.40%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 180.803ms | ±0.10%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 895.961ms | ±0.28%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.147ms   | ±92.64%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.499ms   | ±0.92%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.436ms   | ±13.53%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.450ms   | ±1.73%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 2.879ms   | ±1.32%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.010ms   | ±0.45%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.072ms   | ±28.05%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.107ms   | ±0.16%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 11.076ms  | ±6.24%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.082ms   | ±45.35%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.235ms   | ±0.43%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.499ms   | ±60.70%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.476ms   | ±23.80%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 6.534ms   | ±0.44%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.377ms   | ±22.30%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.627ms   | ±123.84% |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 10.665ms  | ±1.36%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 4.628ms   | ±99.78%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.151ms   | ±16.79%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 531.546μs | ±9.70%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 2.967ms   | ±0.64%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.344ms   | ±0.58%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.013ms   | ±49.90%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 226.204ms | ±15.37%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.312ms   | ±2.51%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 9.058ms   | ±93.09%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 5.346ms   | ±30.90%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.100ms  | ±0.82%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.074ms  | ±67.62%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.993ms  | ±46.66%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 19.515ms  | ±36.04%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 29.049ms  | ±22.64%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 844.194μs | ±182.63% |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 822.873μs | ±4.34%   |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 896.080μs | ±1.26%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.506ms   | ±2.03%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.277ms   | ±0.40%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 24.576ms  | ±1.48%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 27.632ms  | ±0.69%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 31.021ms  | ±0.47%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 56.335ms  | ±0.43%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 88.151ms  | ±0.73%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 10.765ms  | ±0.50%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 14.643ms  | ±0.41%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 19.202ms  | ±1.45%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 61.169ms  | ±2.13%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 135.306ms | ±1.31%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 4.639ms   | ±14.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 41.355ms  | ±0.42%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.311μs   | ±30.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.322μs   | ±13.61%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 0.989μs   | ±18.84%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 174.371ms | ±14.52%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 394.922μs | ±1.25%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.654ms   | ±0.53%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.260ms   | ±72.36%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 9.583ms   | ±22.71%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 68.718ms  | ±0.27%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 11.571ms  | ±0.59%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 20.686ms  | ±0.41%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 182.008ms | ±23.32%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 11.337ms  | ±1.21%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 11.541ms  | ±8.81%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 11.720ms  | ±1.00%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 11.755ms  | ±52.57%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 11.903ms  | ±0.20%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 2.972ms   | ±0.84%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 11.628ms  | ±0.92%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 11.581ms  | ±1.68%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 11.381ms  | ±0.91%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 2.978ms   | ±1.92%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.173ms   | ±1.13%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.404ms   | ±1.90%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.319ms   | ±0.27%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 7.810ms   | ±0.13%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 16.673ms  | ±0.28%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 17.720ms  | ±0.15%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 18.730ms  | ±0.91%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 27.219ms  | ±0.29%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 38.369ms  | ±0.08%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.044ms   | ±2.05%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.122ms   | ±13.43%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.244ms   | ±0.95%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.922ms   | ±0.80%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.759ms   | ±0.30%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 34.311μs  | ±2.28%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 214.506μs | ±4.45%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.314mb | 66.191ms  | ±0.14%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.149mb | 283.682ms | ±0.10%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.813mb | 1.110s    | ±0.42%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.341mb | 198.128ms | ±0.11%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.925mb | 152.617ms | ±0.19%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.099mb | 124.485ms | ±1.64%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.150mb | 168.781ms | ±0.36%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.699mb | 140.005ms | ±0.28%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.194mb | 263.057ms | ±0.16%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.772mb | 41.451ms  | ±0.07%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.757mb | 36.181ms  | ±0.65%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.686mb | 34.646ms  | ±0.28%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.922mb | 110.313ms | ±0.02%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.681mb | 37.833ms  | ±1.00%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.958mb | 47.546ms  | ±0.76%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.374mb | 69.699ms  | ±0.26%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.653mb | 31.047ms  | ±0.40%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.590mb | 37.557ms  | ±0.34%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.618mb | 39.013ms  | ±0.26%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.586mb | 38.011ms  | ±0.15%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.609mb | 36.940ms  | ±0.14%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.577mb | 59.996ms  | ±0.42%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.630mb | 36.175ms  | ±0.16%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.306mb | 32.476ms  | ±0.11%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.555mb | 34.769ms  | ±3.88%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.576mb | 38.866ms  | ±0.31%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.569mb | 38.730ms  | ±2.64%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.797mb | 35.653ms  | ±0.43%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.941mb | 176.297ms | ±0.69%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.218mb | 135.947ms | ±1.92%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 7.675ms   | ±0.75%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 7.312ms   | ±0.64%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 7.421ms   | ±0.67%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```