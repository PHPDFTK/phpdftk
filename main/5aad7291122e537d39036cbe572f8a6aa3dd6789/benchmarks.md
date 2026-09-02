# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-02 20:35:54 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.638ms | 2.470ms | 2.731ms | 4.678ms | 6.937ms |
| FPDF | 773.119μs | 833.511μs | 927.010μs | 1.535ms | 2.264ms |
| TCPDF | 10.074ms | 10.903ms | 11.791ms | 19.179ms | 28.240ms |
| mPDF | 25.549ms | 28.938ms | 32.471ms | 60.892ms | 94.806ms |
| Dompdf | 11.115ms | 15.097ms | 19.859ms | 66.497ms | 148.075ms |

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
| phpdftk | 3.285ms | 3.477ms | 3.720ms | 5.743ms | 8.173ms |
| FPDF | 1.026ms | 1.133ms | 1.225ms | 1.935ms | 2.705ms |
| TCPDF | 17.039ms | 17.974ms | 19.192ms | 27.513ms | 38.126ms |

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
| Pdf (Level 3) | 3.324ms | 4.320ms | 12.037ms |
| PdfDoc (Level 2) | 2.658ms | 3.158ms | 7.358ms |
| PdfWriter (Level 1) | 2.290ms | 2.708ms | 6.761ms |

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
| Pdf (Level 3) | 4.302ms | 11.846ms | 45.210ms |
| PdfDoc (Level 2) | 3.731ms | 9.778ms | — |

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
| Pdf (Level 3) | 4.052ms | 11.446ms | 44.929ms |
| PdfDoc (Level 2) | 3.246ms | 7.226ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.146ms | 1.639ms | 6.016ms |
| smalot/pdfparser | 1.995ms | 2.349ms | 5.522ms |
| setasign/fpdi | 1.896ms | 2.713ms | 28.868ms |

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
| phpdftk | 2.011ms | 1.331ms |
| smalot/pdfparser | FAIL | 1.897ms |
| setasign/fpdi | 2.881ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 9.570ms   | ±2.00%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 9.865ms   | ±0.75%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 11.648ms  | ±4.43%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 11.282ms  | ±2.58%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 10.762ms  | ±0.76%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 9.912ms   | ±1.02%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 17.636ms  | ±2.40%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 2.950ms   | ±0.28%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.052ms   | ±1.64%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.446ms  | ±0.27%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 44.929ms  | ±6.55%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.246ms   | ±0.76%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.226ms   | ±0.71%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.061μs   | ±20.20% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.309μs   | ±30.30% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.389mb | 15.969ms  | ±0.62%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.389mb | 16.165ms  | ±0.88%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.129mb | 52.986ms  | ±1.26%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.717mb | 114.603ms | ±3.57%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.356mb | 1.355s    | ±3.60%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.220mb | 23.702ms  | ±2.94%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.246mb | 51.557ms  | ±1.97%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.057mb | 470.006ms | ±1.59%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.503mb | 64.688ms  | ±9.10%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.223mb | 83.464ms  | ±1.21%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.992mb | 656.846ms | ±0.66%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.268mb | 17.718ms  | ±0.85%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.268mb | 40.996ms  | ±0.24%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.910mb | 276.393ms | ±0.62%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.302ms   | ±0.07%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 11.846ms  | ±0.34%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 45.210ms  | ±1.58%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.731ms   | ±2.92%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 9.778ms   | ±1.58%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.238ms   | ±0.94%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.639ms   | ±0.67%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.016ms   | ±6.98%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.011ms   | ±0.53%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.331ms   | ±0.56%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.995ms   | ±1.03%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.349ms   | ±0.53%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.522ms   | ±0.58%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 560.416μs | ±4.62%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.897ms   | ±0.58%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.896ms   | ±1.40%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.713ms   | ±0.20%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 28.868ms  | ±0.43%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.881ms   | ±0.36%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.494ms   | ±0.78%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.086ms   | ±0.79%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.343ms   | ±1.04%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.808ms   | ±0.56%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 4.291μs   | ±50.53% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.146ms   | ±1.31%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.472mb  | 28.345ms  | ±7.33%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.480mb | 217.648ms | ±3.37%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.098mb | 1.237s    | ±7.16%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.290ms   | ±1.09%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.708ms   | ±1.14%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.761ms   | ±0.60%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.658ms   | ±1.04%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.158ms   | ±0.95%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.358ms   | ±0.64%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.324ms   | ±0.24%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.320ms   | ±0.66%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.037ms  | ±0.42%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.262ms   | ±1.44%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.470ms   | ±0.50%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.731ms   | ±1.39%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.678ms   | ±0.54%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 6.937ms   | ±0.73%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.494ms   | ±0.49%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.723ms   | ±0.77%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.972ms  | ±61.63% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.529ms   | ±0.48%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.332ms   | ±0.92%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 599.302μs | ±1.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.105ms   | ±11.52% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.537ms   | ±0.50%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.135ms   | ±0.42%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 200.334ms | ±19.91% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.497ms   | ±0.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.799ms   | ±59.54% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 5.922ms   | ±0.80%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.074ms  | ±0.71%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.903ms  | ±0.18%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.791ms  | ±0.51%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 19.179ms  | ±0.26%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 28.240ms  | ±1.05%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 773.119μs | ±1.57%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 833.511μs | ±1.61%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 927.010μs | ±1.03%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.535ms   | ±0.63%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.264ms   | ±0.53%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.549ms  | ±1.59%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.938ms  | ±0.17%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.471ms  | ±0.08%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 60.892ms  | ±0.89%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 94.806ms  | ±1.31%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.115ms  | ±0.38%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.097ms  | ±0.21%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 19.859ms  | ±0.42%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 66.497ms  | ±0.66%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 148.075ms | ±0.49%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 4.898ms   | ±0.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 53.225ms  | ±0.58%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 208.227ms | ±39.45% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 483.785μs | ±1.26%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.879ms   | ±0.26%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.309ms   | ±0.87%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 11.285ms  | ±8.31%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 81.303ms  | ±0.45%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 15.250ms  | ±0.53%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 26.293ms  | ±1.11%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 276.129ms | ±22.77% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.764ms  | ±0.54%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.803ms  | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.824ms  | ±1.58%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.919ms  | ±0.53%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.324ms  | ±1.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.075ms   | ±0.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.975ms  | ±0.31%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.908ms  | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.638ms  | ±0.57%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.285ms   | ±0.85%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.477ms   | ±0.42%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.720ms   | ±0.81%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.743ms   | ±0.20%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.173ms   | ±0.13%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.039ms  | ±0.23%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 17.974ms  | ±0.63%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.192ms  | ±0.19%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 27.513ms  | ±0.22%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 38.126ms  | ±0.36%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.026ms   | ±0.70%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.133ms   | ±0.25%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.225ms   | ±0.83%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.935ms   | ±0.63%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.705ms   | ±0.20%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 42.753μs  | ±0.95%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 235.128μs | ±0.44%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.417mb | 77.862ms  | ±0.20%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.203mb | 354.929ms | ±3.76%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.866mb | 1.311s    | ±0.34%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.434mb | 236.004ms | ±1.96%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.990mb | 194.594ms | ±1.15%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.205mb | 148.659ms | ±3.49%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.252mb | 199.334ms | ±0.30%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.801mb | 162.846ms | ±2.96%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.296mb | 313.206ms | ±0.21%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.940mb | 51.682ms  | ±3.60%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.860mb | 42.522ms  | ±2.68%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.789mb | 40.238ms  | ±0.23%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.095mb | 129.798ms | ±0.67%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.849mb | 43.917ms  | ±2.15%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 16.060mb | 55.209ms  | ±0.24%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.477mb | 82.190ms  | ±0.99%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.755mb | 35.809ms  | ±0.67%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.693mb | 44.566ms  | ±1.90%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.720mb | 45.682ms  | ±0.58%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.689mb | 44.566ms  | ±2.57%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.777mb | 42.724ms  | ±1.23%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.631mb | 70.187ms  | ±0.77%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.703mb | 43.137ms  | ±1.16%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.360mb | 37.135ms  | ±0.38%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.658mb | 40.646ms  | ±0.22%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.678mb | 45.460ms  | ±0.19%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.672mb | 47.267ms  | ±0.65%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.871mb | 41.745ms  | ±1.50%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 19.051mb | 221.285ms | ±1.33%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.321mb | 165.938ms | ±1.51%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 8.719ms   | ±0.70%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.289ms   | ±2.67%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.311ms   | ±0.41%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```