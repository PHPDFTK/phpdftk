# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-04 01:19:31 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.253ms | 2.497ms | 2.735ms | 4.784ms | 7.057ms |
| FPDF | 814.607μs | 888.188μs | 974.175μs | 1.540ms | 2.322ms |
| TCPDF | 10.545ms | 11.561ms | 12.630ms | 21.347ms | 32.185ms |
| mPDF | 26.773ms | 31.028ms | 35.243ms | 67.180ms | 106.422ms |
| Dompdf | 11.294ms | 16.055ms | 21.901ms | 72.101ms | 161.714ms |

## Peak Memory — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 9.218mb | 5.947mb | 6.033mb | 6.667mb | 7.490mb |
| FPDF | 5.072mb | 5.072mb | 5.072mb | 5.072mb | 5.084mb |
| TCPDF | 12.912mb | 12.912mb | 12.912mb | 12.912mb | 12.912mb |
| mPDF | 17.624mb | 17.683mb | 17.721mb | 18.014mb | 18.376mb |
| Dompdf | 9.357mb | 9.577mb | 9.898mb | 12.591mb | 15.954mb |

## Generation Time — `MemoryBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 3.351ms | 3.552ms | 3.880ms | 5.913ms | 8.349ms |
| FPDF | 1.086ms | 1.153ms | 1.256ms | 1.948ms | 2.799ms |
| TCPDF | 17.783ms | 19.034ms | 19.851ms | 30.763ms | 42.438ms |

## Peak Memory — `MemoryBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 5.373mb | 5.420mb | 5.479mb | 5.972mb | 6.570mb |
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
| Pdf (Level 3) | 3.388ms | 4.549ms | 12.551ms |
| PdfDoc (Level 2) | 2.662ms | 3.150ms | 7.452ms |
| PdfWriter (Level 1) | 2.311ms | 2.756ms | 6.884ms |

### Peak Memory

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| Pdf (Level 3) | 6.057mb | 6.220mb | 7.897mb |
| PdfDoc (Level 2) | 5.714mb | 5.872mb | 7.441mb |
| PdfWriter (Level 1) | 5.389mb | 5.548mb | 7.123mb |

## Tables — `TablesBench`

Table rendering through `Pdf::addTable()` (Level 3, flow-paginated)
and `Writer\Page::drawTable()` (Level 2, positioned). Both share the
same underlying `TableRenderer`; the delta isolates the cost of the
flow-layout engine.

### Generation Time

| Library | 10 rows | 100 rows | 500 rows |
|---|---|---|---|
| Pdf (Level 3) | 4.323ms | 11.980ms | 46.582ms |
| PdfDoc (Level 2) | 3.731ms | 9.939ms | — |

### Peak Memory

| Library | 10 rows | 100 rows | 500 rows |
|---|---|---|---|
| Pdf (Level 3) | 6.408mb | 9.203mb | 21.611mb |
| PdfDoc (Level 2) | 6.214mb | 9.029mb | — |

## Lists — `ListsBench`

Bullet-list rendering through `Pdf::addList()` (Level 3) and
`Writer\Page::drawList()` (Level 2). Both share `ListRenderer`.

### Generation Time

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 4.025ms | 11.654ms | 44.660ms |
| PdfDoc (Level 2) | 3.279ms | 7.295ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.040mb | 6.592mb | 9.036mb |
| PdfDoc (Level 2) | 5.829mb | 6.323mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.173ms | 1.656ms | 5.933ms |
| smalot/pdfparser | 1.980ms | 2.346ms | 5.731ms |
| setasign/fpdi | 1.936ms | 2.830ms | 29.884ms |

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
| phpdftk | 2.008ms | 1.363ms |
| smalot/pdfparser | FAIL | 1.895ms |
| setasign/fpdi | 2.974ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.308mb  | 10.299ms  | ±0.41%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.202mb  | 10.206ms  | ±3.66%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.353mb  | 11.843ms  | ±0.33%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.050mb  | 12.037ms  | ±0.57%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.535mb  | 10.879ms  | ±0.61%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.607mb  | 10.195ms  | ±0.22%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.852mb | 19.438ms  | ±4.01%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.752mb  | 3.008ms   | ±1.60%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.040mb  | 4.025ms   | ±0.48%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.592mb  | 11.654ms  | ±2.95%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.036mb  | 44.660ms  | ±0.41%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.829mb  | 3.279ms   | ±4.35%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.323mb  | 7.295ms   | ±0.77%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.966μs   | ±19.64% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.986μs   | ±26.50% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.451mb | 15.970ms  | ±0.38%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.451mb | 15.995ms  | ±0.26%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.204mb | 57.291ms  | ±1.27%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.811mb | 115.651ms | ±2.64%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.879mb | 1.405s    | ±0.20%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.266mb | 25.606ms  | ±2.63%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.292mb | 57.926ms  | ±1.08%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.103mb | 515.941ms | ±0.12%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.549mb | 64.046ms  | ±9.47%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.269mb | 85.672ms  | ±1.90%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 33.038mb | 728.597ms | ±0.61%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.314mb | 18.542ms  | ±0.42%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.314mb | 43.084ms  | ±0.33%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.956mb | 317.117ms | ±0.40%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.408mb  | 4.323ms   | ±0.40%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.203mb  | 11.980ms  | ±0.24%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.611mb | 46.582ms  | ±0.51%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.214mb  | 3.731ms   | ±1.20%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.029mb  | 9.939ms   | ±0.61%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.231ms   | ±0.92%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.656ms   | ±2.36%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.933ms   | ±0.54%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.008ms   | ±0.62%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.363ms   | ±0.62%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.980ms   | ±1.11%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.346ms   | ±2.74%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.731ms   | ±0.88%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 540.159μs | ±2.03%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.895ms   | ±0.62%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.936ms   | ±0.42%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.830ms   | ±1.21%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.884ms  | ±0.63%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.974ms   | ±1.26%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.505ms   | ±0.70%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.960mb  | 7.266ms   | ±0.97%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.932mb  | 5.398ms   | ±0.54%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.976mb  | 3.818ms   | ±0.34%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.273μs   | ±15.71% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.173ms   | ±0.96%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.503mb  | 26.488ms  | ±0.18%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.671mb | 240.901ms | ±0.72%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.999mb | 1.186s    | ±0.46%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.389mb  | 2.311ms   | ±0.45%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.548mb  | 2.756ms   | ±0.34%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.123mb  | 6.884ms   | ±0.55%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.714mb  | 2.662ms   | ±1.10%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.872mb  | 3.150ms   | ±1.16%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.441mb  | 7.452ms   | ±1.43%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.057mb  | 3.388ms   | ±1.47%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.220mb  | 4.549ms   | ±0.51%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.897mb  | 12.551ms  | ±1.18%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.886mb  | 2.334ms   | ±1.29%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.947mb  | 2.497ms   | ±1.33%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.033mb  | 2.735ms   | ±0.43%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.667mb  | 4.784ms   | ±0.60%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.490mb  | 7.057ms   | ±2.95%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.350mb  | 3.564ms   | ±0.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.342mb  | 3.833ms   | ±0.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.779mb  | 12.295ms  | ±9.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.394mb  | 3.638ms   | ±1.19%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.675mb  | 2.373ms   | ±5.42%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 658.204μs | ±0.91%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.104mb  | 3.154ms   | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.198mb  | 3.622ms   | ±0.84%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.119mb  | 3.167ms   | ±0.51%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.175mb  | 259.049ms | ±16.48% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.236mb  | 3.686ms   | ±12.79% |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.851mb  | 5.960ms   | ±23.64% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.983mb  | 6.183ms   | ±0.82%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.545ms  | ±1.15%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.561ms  | ±1.20%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.630ms  | ±0.73%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 21.347ms  | ±0.82%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 32.185ms  | ±1.10%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 814.607μs | ±2.36%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 888.188μs | ±1.09%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 974.175μs | ±1.68%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.540ms   | ±1.22%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.322ms   | ±0.80%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 26.773ms  | ±2.00%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 31.028ms  | ±0.82%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 35.243ms  | ±0.98%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 67.180ms  | ±0.49%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 106.422ms | ±0.68%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.294ms  | ±2.41%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.055ms  | ±2.61%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.901ms  | ±1.94%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 72.101ms  | ±0.88%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 161.714ms | ±0.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.049mb  | 5.128ms   | ±11.02% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.496mb  | 50.003ms  | ±0.49%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.344μs   | ±11.13% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.624μs   | ±18.18% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 189.072ms | ±11.40% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 462.950μs | ±1.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.463mb  | 3.000ms   | ±0.35%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.060mb  | 3.501ms   | ±2.60%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 13.980ms  | ±7.36%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 85.064ms  | ±0.67%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.045ms  | ±0.54%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 24.909ms  | ±1.25%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.896mb  | 311.461ms | ±26.86% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.288mb  | 13.487ms  | ±0.67%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.261mb  | 13.244ms  | ±3.04%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.269mb  | 13.454ms  | ±4.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.285mb  | 13.593ms  | ±0.56%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.390mb  | 13.915ms  | ±0.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.057mb  | 3.111ms   | ±0.50%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.272mb  | 13.512ms  | ±0.55%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.323mb  | 13.504ms  | ±2.16%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.218mb  | 13.253ms  | ±0.52%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.373mb  | 3.351ms   | ±1.09%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.420mb  | 3.552ms   | ±0.61%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.479mb  | 3.880ms   | ±0.77%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.972mb  | 5.913ms   | ±0.79%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.570mb  | 8.349ms   | ±0.71%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.783ms  | ±0.29%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 19.034ms  | ±0.73%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.851ms  | ±0.46%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 30.763ms  | ±2.01%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 42.438ms  | ±0.90%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.086ms   | ±2.68%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.153ms   | ±0.96%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.256ms   | ±1.21%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.948ms   | ±1.42%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.799ms   | ±0.37%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 42.273μs  | ±0.78%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.506mb  | 250.188μs | ±0.77%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.505mb | 87.856ms  | ±0.46%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.397mb | 380.238ms | ±0.99%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 45.459mb | 1.480s    | ±1.14%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.571mb | 265.479ms | ±0.34%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 32.467mb | 205.005ms | ±1.28%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.314mb | 165.464ms | ±0.45%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.385mb | 225.368ms | ±0.54%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.922mb | 187.262ms | ±1.35%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.476mb | 346.036ms | ±0.75%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 16.017mb | 51.951ms  | ±0.27%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.933mb | 45.498ms  | ±0.81%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.859mb | 42.377ms  | ±0.28%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.201mb | 143.477ms | ±0.44%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.922mb | 47.258ms  | ±0.28%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 16.140mb | 60.406ms  | ±0.62%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.568mb | 90.216ms  | ±0.61%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.826mb | 38.645ms  | ±0.67%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.763mb | 46.043ms  | ±0.50%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.790mb | 47.756ms  | ±0.14%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.759mb | 46.884ms  | ±0.32%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.847mb | 45.142ms  | ±0.25%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.700mb | 71.390ms  | ±0.20%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.774mb | 43.704ms  | ±0.19%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.426mb | 39.050ms  | ±0.61%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.728mb | 43.117ms  | ±0.29%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.749mb | 47.896ms  | ±0.47%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.742mb | 47.521ms  | ±0.28%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.941mb | 42.535ms  | ±0.17%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 19.178mb | 230.282ms | ±0.48%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.397mb | 171.724ms | ±0.66%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.802mb  | 8.905ms   | ±0.73%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.616mb  | 8.478ms   | ±0.31%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.825mb  | 8.554ms   | ±0.65%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```