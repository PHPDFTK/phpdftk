# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-02 19:49:29 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.648ms | 2.582ms | 2.826ms | 4.826ms | 7.054ms |
| FPDF | 827.609μs | 901.721μs | 958.830μs | 1.557ms | 2.295ms |
| TCPDF | 10.107ms | 11.362ms | 12.781ms | 21.120ms | 31.580ms |
| mPDF | 26.571ms | 29.889ms | 34.025ms | 65.926ms | 107.305ms |
| Dompdf | 11.523ms | 15.964ms | 21.500ms | 75.222ms | 164.161ms |

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
| phpdftk | 3.345ms | 3.649ms | 3.913ms | 5.887ms | 8.389ms |
| FPDF | 1.124ms | 1.147ms | 1.281ms | 1.922ms | 2.778ms |
| TCPDF | 17.348ms | 19.392ms | 20.043ms | 29.584ms | 42.086ms |

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
| Pdf (Level 3) | 3.457ms | 4.564ms | 12.780ms |
| PdfDoc (Level 2) | 2.781ms | 3.154ms | 7.593ms |
| PdfWriter (Level 1) | 2.358ms | 2.759ms | 7.062ms |

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
| Pdf (Level 3) | 4.442ms | 12.163ms | 47.237ms |
| PdfDoc (Level 2) | 3.779ms | 9.945ms | — |

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
| Pdf (Level 3) | 4.087ms | 11.772ms | 45.708ms |
| PdfDoc (Level 2) | 3.369ms | 7.384ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.350ms | 1.667ms | 6.078ms |
| smalot/pdfparser | 2.014ms | 2.411ms | 5.811ms |
| setasign/fpdi | 1.930ms | 2.929ms | 30.426ms |

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
| phpdftk | 2.041ms | 1.370ms |
| smalot/pdfparser | FAIL | 1.935ms |
| setasign/fpdi | 3.020ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 10.388ms  | ±0.96%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 10.391ms  | ±1.95%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 12.082ms  | ±0.71%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 12.139ms  | ±0.91%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 11.285ms  | ±4.07%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 10.529ms  | ±0.47%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 19.286ms  | ±0.31%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 3.077ms   | ±0.60%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.087ms   | ±0.72%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.772ms  | ±0.79%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.708ms  | ±0.46%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.369ms   | ±1.23%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.384ms   | ±0.95%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.976μs   | ±23.16% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.085μs   | ±26.76% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.327mb | 16.281ms  | ±0.59%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.327mb | 16.898ms  | ±1.85%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.064mb | 58.041ms  | ±0.49%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.655mb | 118.586ms | ±0.44%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.306mb | 1.391s    | ±0.40%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.220mb | 26.370ms  | ±3.41%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.246mb | 59.481ms  | ±1.51%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.057mb | 542.663ms | ±0.72%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.503mb | 65.658ms  | ±8.89%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.223mb | 88.557ms  | ±0.78%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.992mb | 749.812ms | ±0.99%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.268mb | 20.128ms  | ±1.26%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.268mb | 44.527ms  | ±1.04%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.910mb | 329.116ms | ±0.34%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.442ms   | ±1.90%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.163ms  | ±0.83%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.237ms  | ±0.62%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.779ms   | ±1.08%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 9.945ms   | ±0.76%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.258ms   | ±1.85%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.667ms   | ±1.12%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.078ms   | ±0.73%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.041ms   | ±0.91%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.370ms   | ±0.91%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.014ms   | ±16.46% |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.411ms   | ±0.94%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.811ms   | ±1.15%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 567.860μs | ±0.95%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.935ms   | ±0.95%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.930ms   | ±1.05%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.929ms   | ±1.19%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 30.426ms  | ±0.65%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.020ms   | ±1.04%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.536ms   | ±2.25%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.612ms   | ±2.27%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.569ms   | ±1.49%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.874ms   | ±1.83%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.719μs   | ±16.72% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.350ms   | ±0.78%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.472mb  | 26.436ms  | ±0.55%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.480mb | 239.792ms | ±2.52%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.098mb | 1.164s    | ±0.18%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.358ms   | ±1.33%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.759ms   | ±2.56%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 7.062ms   | ±3.10%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.781ms   | ±1.02%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.154ms   | ±0.95%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.593ms   | ±0.86%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.457ms   | ±2.41%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.564ms   | ±2.49%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.780ms  | ±1.28%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.346ms   | ±1.09%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.582ms   | ±1.40%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.826ms   | ±4.74%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.826ms   | ±0.68%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.054ms   | ±0.90%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.590ms   | ±2.09%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.886ms   | ±0.48%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.491ms  | ±13.29% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.642ms   | ±6.18%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.415ms   | ±1.42%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 617.402μs | ±5.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.246ms   | ±0.52%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.715ms   | ±3.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.343ms   | ±1.24%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 158.204ms | ±33.56% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.686ms   | ±1.40%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.937ms   | ±14.07% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.147ms   | ±1.75%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.107ms  | ±7.01%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.362ms  | ±3.42%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.781ms  | ±2.35%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 21.120ms  | ±1.01%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.580ms  | ±0.88%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 827.609μs | ±2.67%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 901.721μs | ±2.22%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 958.830μs | ±6.76%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.557ms   | ±1.30%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.295ms   | ±0.61%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 26.571ms  | ±1.96%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.889ms  | ±2.56%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 34.025ms  | ±0.71%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.926ms  | ±1.52%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 107.305ms | ±0.29%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.523ms  | ±1.09%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.964ms  | ±0.84%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.500ms  | ±1.22%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 75.222ms  | ±0.85%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 164.161ms | ±1.16%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.184ms   | ±2.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.276ms  | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 172.458ms | ±15.70% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 456.657μs | ±1.93%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.007ms   | ±0.53%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.543ms   | ±2.19%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 14.475ms  | ±1.22%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 85.824ms  | ±0.56%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.460ms  | ±2.04%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.432ms  | ±1.06%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 191.657ms | ±50.17% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.402ms  | ±1.02%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.450ms  | ±0.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.652ms  | ±0.55%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.654ms  | ±2.26%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.336ms  | ±0.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.227ms   | ±2.42%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.979ms  | ±1.31%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.695ms  | ±0.86%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.648ms  | ±2.03%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.345ms   | ±0.38%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.649ms   | ±0.94%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.913ms   | ±0.68%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.887ms   | ±0.60%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.389ms   | ±0.92%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.348ms  | ±2.02%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 19.392ms  | ±1.60%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 20.043ms  | ±0.86%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.584ms  | ±0.30%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 42.086ms  | ±1.13%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.124ms   | ±4.52%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.147ms   | ±0.62%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.281ms   | ±0.86%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.922ms   | ±1.17%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.778ms   | ±0.46%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 42.066μs  | ±1.10%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 251.397μs | ±1.31%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.355mb | 86.743ms  | ±0.32%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.185mb | 374.383ms | ±1.12%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.848mb | 1.451s    | ±0.43%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.416mb | 261.285ms | ±0.65%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.972mb | 197.606ms | ±0.97%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.143mb | 162.291ms | ±0.52%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.190mb | 221.404ms | ±0.38%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.739mb | 182.129ms | ±1.00%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.234mb | 348.967ms | ±0.44%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.878mb | 53.424ms  | ±0.10%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.798mb | 47.474ms  | ±0.73%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.727mb | 44.429ms  | ±0.56%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.028mb | 144.345ms | ±0.50%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.786mb | 49.102ms  | ±0.08%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.998mb | 62.646ms  | ±0.43%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.415mb | 91.128ms  | ±0.45%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.693mb | 39.694ms  | ±0.77%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.631mb | 47.975ms  | ±0.63%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.658mb | 49.848ms  | ±1.27%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.627mb | 48.317ms  | ±1.09%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.715mb | 47.557ms  | ±0.77%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.612mb | 74.775ms  | ±0.47%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.685mb | 45.817ms  | ±0.76%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.342mb | 40.948ms  | ±1.27%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.595mb | 44.821ms  | ±1.35%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.616mb | 51.067ms  | ±1.06%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.609mb | 48.348ms  | ±1.09%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.853mb | 43.126ms  | ±1.16%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.981mb | 227.898ms | ±0.87%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.259mb | 172.201ms | ±0.50%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.108ms   | ±0.44%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.545ms   | ±0.71%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.797ms   | ±0.97%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```