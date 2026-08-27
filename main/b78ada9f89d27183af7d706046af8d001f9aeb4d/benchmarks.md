# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-27 02:37:24 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.353ms | 2.532ms | 2.807ms | 4.840ms | 7.109ms |
| FPDF | 789.863μs | 830.482μs | 925.616μs | 1.550ms | 2.277ms |
| TCPDF | 10.005ms | 10.983ms | 12.180ms | 20.612ms | 31.321ms |
| mPDF | 25.213ms | 29.069ms | 33.880ms | 65.825ms | 104.967ms |
| Dompdf | 11.334ms | 16.208ms | 21.573ms | 73.887ms | 162.943ms |

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
| phpdftk | 3.434ms | 3.604ms | 3.877ms | 5.910ms | 8.532ms |
| FPDF | 1.089ms | 1.097ms | 1.218ms | 1.904ms | 2.739ms |
| TCPDF | 17.314ms | 18.235ms | 19.464ms | 29.544ms | 41.591ms |

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
| Pdf (Level 3) | 3.420ms | 4.486ms | 12.776ms |
| PdfDoc (Level 2) | 2.709ms | 3.173ms | 7.578ms |
| PdfWriter (Level 1) | 2.353ms | 2.811ms | 6.960ms |

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
| Pdf (Level 3) | 4.400ms | 12.346ms | 47.367ms |
| PdfDoc (Level 2) | 3.815ms | 10.209ms | — |

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
| Pdf (Level 3) | 4.133ms | 11.874ms | 45.830ms |
| PdfDoc (Level 2) | 3.322ms | 7.430ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.225ms | 1.680ms | 6.015ms |
| smalot/pdfparser | 2.026ms | 2.420ms | 5.838ms |
| setasign/fpdi | 1.945ms | 2.853ms | 29.981ms |

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
| phpdftk | 2.059ms | 1.383ms |
| smalot/pdfparser | FAIL | 1.922ms |
| setasign/fpdi | 2.985ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 10.358ms  | ±3.41%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 10.420ms  | ±0.66%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 11.910ms  | ±2.89%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 12.007ms  | ±0.99%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 11.101ms  | ±1.00%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 10.503ms  | ±6.49%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 19.399ms  | ±0.77%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 3.055ms   | ±0.81%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.133ms   | ±0.79%   |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.874ms  | ±1.87%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.830ms  | ±1.04%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.322ms   | ±1.00%   |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.430ms   | ±7.26%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.673μs   | ±28.28%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.976μs   | ±23.16%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.191mb | 15.899ms  | ±0.40%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.191mb | 15.865ms  | ±0.27%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 15.994mb | 54.921ms  | ±3.85%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.585mb | 113.279ms | ±0.31%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.243mb | 1.362s    | ±0.47%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.174mb | 25.985ms  | ±3.06%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.200mb | 59.626ms  | ±1.32%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.011mb | 539.248ms | ±0.23%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.458mb | 63.916ms  | ±9.48%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.177mb | 85.510ms  | ±1.23%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.946mb | 736.094ms | ±0.71%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.222mb | 19.015ms  | ±3.71%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.222mb | 43.156ms  | ±0.86%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.865mb | 327.405ms | ±1.03%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.400ms   | ±1.79%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.346ms  | ±0.85%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.367ms  | ±2.71%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.815ms   | ±0.67%   |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.209ms  | ±85.34%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.243ms   | ±2.38%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.680ms   | ±0.99%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.015ms   | ±1.01%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.059ms   | ±0.81%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.383ms   | ±0.73%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.026ms   | ±1.08%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.420ms   | ±0.80%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.838ms   | ±0.69%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 560.251μs | ±0.92%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.922ms   | ±0.35%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.945ms   | ±0.58%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.853ms   | ±0.55%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.981ms  | ±0.74%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.985ms   | ±0.41%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.526ms   | ±0.24%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.320ms   | ±1.00%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.474ms   | ±0.59%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.872ms   | ±1.09%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.519μs   | ±17.58%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.225ms   | ±0.64%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 25.337ms  | ±0.50%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 231.207ms | ±0.91%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 1.140s    | ±0.28%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.353ms   | ±0.74%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.811ms   | ±1.00%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.960ms   | ±0.53%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.709ms   | ±0.71%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.173ms   | ±1.17%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.578ms   | ±0.76%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.420ms   | ±5.64%   |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.486ms   | ±0.33%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.776ms  | ±3.75%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.312ms   | ±0.90%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.532ms   | ±0.47%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.807ms   | ±0.91%   |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.840ms   | ±0.71%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.109ms   | ±0.19%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.618ms   | ±0.40%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.893ms   | ±1.65%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.336ms  | ±1.33%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.672ms   | ±0.57%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.404ms   | ±0.82%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 647.491μs | ±6.43%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.208ms   | ±0.95%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.676ms   | ±0.88%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.319ms   | ±0.77%   |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 168.239ms | ±44.45%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.612ms   | ±1.18%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.869ms   | ±25.99%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.094ms   | ±1.02%   |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.005ms  | ±0.60%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.983ms  | ±0.14%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.180ms  | ±0.48%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.612ms  | ±0.55%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.321ms  | ±1.07%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 789.863μs | ±2.86%   |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 830.482μs | ±1.41%   |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 925.616μs | ±2.18%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.550ms   | ±1.83%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.277ms   | ±0.82%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.213ms  | ±1.85%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.069ms  | ±1.55%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.880ms  | ±0.76%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.825ms  | ±0.84%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 104.967ms | ±0.48%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.334ms  | ±0.59%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.208ms  | ±4.90%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.573ms  | ±0.44%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 73.887ms  | ±0.68%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 162.943ms | ±0.31%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.172ms   | ±0.89%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.497ms  | ±1.28%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.522μs   | ±115.33% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.680μs   | ±88.89%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 197.545ms | ±13.50%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 464.912μs | ±0.60%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.070ms   | ±2.50%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.433ms   | ±0.71%   |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 12.801ms  | ±4.56%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 87.593ms  | ±0.73%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.855ms  | ±0.25%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.017ms  | ±0.46%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 250.509ms | ±18.13%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.501ms  | ±0.59%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.588ms  | ±0.88%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.583ms  | ±1.22%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.579ms  | ±0.20%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.000ms  | ±0.40%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.244ms   | ±1.16%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.625ms  | ±0.74%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.594ms  | ±0.27%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.353ms  | ±1.12%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.434ms   | ±17.11%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.604ms   | ±0.24%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.877ms   | ±0.77%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.910ms   | ±0.39%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.532ms   | ±1.14%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.314ms  | ±0.47%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.235ms  | ±1.14%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.464ms  | ±0.32%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.544ms  | ±0.66%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.591ms  | ±0.71%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.089ms   | ±5.39%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.097ms   | ±1.03%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.218ms   | ±1.47%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.904ms   | ±1.08%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.739ms   | ±1.02%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.431μs  | ±6.15%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 242.817μs | ±0.92%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.284mb | 82.644ms  | ±0.42%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.121mb | 363.436ms | ±0.44%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.784mb | 1.416s    | ±1.29%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.311mb | 248.569ms | ±1.36%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.895mb | 194.299ms | ±0.80%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.069mb | 156.131ms | ±0.63%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.120mb | 214.021ms | ±0.71%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.669mb | 177.292ms | ±0.41%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.164mb | 331.640ms | ±0.37%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.742mb | 50.842ms  | ±1.28%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.727mb | 44.816ms  | ±0.49%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.656mb | 42.198ms  | ±0.75%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.892mb | 138.472ms | ±0.57%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.651mb | 46.101ms  | ±0.57%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.928mb | 58.629ms  | ±0.28%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.344mb | 87.923ms  | ±0.56%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.623mb | 37.557ms  | ±0.29%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.560mb | 45.569ms  | ±0.12%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.588mb | 47.283ms  | ±1.35%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.556mb | 46.174ms  | ±0.67%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.579mb | 44.922ms  | ±0.26%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.549mb | 71.204ms  | ±1.37%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.602mb | 43.458ms  | ±0.13%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.278mb | 38.871ms  | ±0.28%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.525mb | 41.901ms  | ±0.73%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.546mb | 47.549ms  | ±0.38%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.539mb | 46.846ms  | ±0.51%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.769mb | 42.555ms  | ±0.35%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.911mb | 220.366ms | ±0.19%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.188mb | 170.743ms | ±0.28%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.046ms   | ±0.64%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.561ms   | ±0.38%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.636ms   | ±6.71%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```