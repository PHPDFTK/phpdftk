# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-03 22:53:19 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.715ms | 2.723ms | 2.968ms | 5.066ms | 7.494ms |
| FPDF | 853.201μs | 895.320μs | 989.767μs | 1.605ms | 2.322ms |
| TCPDF | 11.186ms | 12.219ms | 13.364ms | 22.170ms | 33.249ms |
| mPDF | 28.345ms | 32.795ms | 36.657ms | 69.959ms | 110.374ms |
| Dompdf | 12.410ms | 17.400ms | 23.511ms | 76.984ms | 170.359ms |

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
| phpdftk | 3.582ms | 3.731ms | 4.065ms | 6.056ms | 8.827ms |
| FPDF | 1.171ms | 1.179ms | 1.293ms | 1.989ms | 2.843ms |
| TCPDF | 18.498ms | 20.008ms | 21.315ms | 31.160ms | 43.869ms |

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
| Pdf (Level 3) | 3.651ms | 4.768ms | 13.399ms |
| PdfDoc (Level 2) | 2.963ms | 3.450ms | 8.149ms |
| PdfWriter (Level 1) | 2.554ms | 3.073ms | 7.378ms |

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
| Pdf (Level 3) | 4.693ms | 12.687ms | 48.115ms |
| PdfDoc (Level 2) | 4.076ms | 10.588ms | — |

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
| Pdf (Level 3) | 4.256ms | 12.132ms | 45.697ms |
| PdfDoc (Level 2) | 3.439ms | 7.551ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.040mb | 6.592mb | 9.036mb |
| PdfDoc (Level 2) | 5.829mb | 6.323mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.579ms | 1.785ms | 6.159ms |
| smalot/pdfparser | 2.150ms | 2.555ms | 6.197ms |
| setasign/fpdi | 2.070ms | 3.001ms | 30.572ms |

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
| phpdftk | 2.149ms | 1.439ms |
| smalot/pdfparser | FAIL | 2.038ms |
| setasign/fpdi | 3.187ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.305mb  | 10.771ms  | ±0.58%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.199mb  | 11.189ms  | ±1.87%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.350mb  | 12.407ms  | ±0.53%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.047mb  | 12.494ms  | ±0.78%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.532mb  | 11.490ms  | ±0.95%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.604mb  | 10.906ms  | ±0.48%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.848mb | 20.489ms  | ±0.36%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.752mb  | 3.165ms   | ±1.70%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.040mb  | 4.256ms   | ±1.86%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.592mb  | 12.132ms  | ±0.24%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.036mb  | 45.697ms  | ±0.53%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.829mb  | 3.439ms   | ±1.63%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.323mb  | 7.551ms   | ±1.24%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.049μs   | ±16.64% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.973μs   | ±46.37% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.430mb | 17.680ms  | ±1.05%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.430mb | 17.192ms  | ±0.67%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.183mb | 60.217ms  | ±0.64%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.790mb | 121.342ms | ±0.78%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.858mb | 1.435s    | ±0.35%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.247mb | 29.083ms  | ±1.84%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.273mb | 66.154ms  | ±1.93%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.084mb | 590.719ms | ±0.52%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.531mb | 69.807ms  | ±9.09%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.250mb | 93.860ms  | ±7.30%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 33.019mb | 792.946ms | ±2.16%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.295mb | 20.801ms  | ±0.27%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.295mb | 45.511ms  | ±0.67%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.938mb | 329.794ms | ±0.25%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.408mb  | 4.693ms   | ±1.24%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.203mb  | 12.687ms  | ±0.38%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.611mb | 48.115ms  | ±0.46%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.214mb  | 4.076ms   | ±0.82%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.029mb  | 10.588ms  | ±1.16%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.321ms   | ±1.12%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.785ms   | ±1.98%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.159ms   | ±0.39%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.149ms   | ±1.68%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.439ms   | ±2.06%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.150ms   | ±1.23%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.555ms   | ±2.15%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 6.197ms   | ±1.01%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 583.577μs | ±1.81%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 2.038ms   | ±1.32%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 2.070ms   | ±1.30%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 3.001ms   | ±0.64%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 30.572ms  | ±0.88%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.187ms   | ±0.66%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.645ms   | ±1.86%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.960mb  | 7.585ms   | ±0.84%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.932mb  | 5.747ms   | ±1.41%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.976mb  | 4.066ms   | ±0.73%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.844μs   | ±24.34% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.579ms   | ±1.81%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.498mb  | 27.589ms  | ±0.21%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.667mb | 244.584ms | ±0.67%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.995mb | 1.199s    | ±0.71%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.389mb  | 2.554ms   | ±0.88%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.548mb  | 3.073ms   | ±2.42%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.123mb  | 7.378ms   | ±0.21%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.714mb  | 2.963ms   | ±1.63%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.872mb  | 3.450ms   | ±12.92% |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.441mb  | 8.149ms   | ±0.91%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.057mb  | 3.651ms   | ±0.83%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.220mb  | 4.768ms   | ±1.75%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.897mb  | 13.399ms  | ±1.33%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.886mb  | 2.528ms   | ±1.08%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.947mb  | 2.723ms   | ±2.08%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.033mb  | 2.968ms   | ±1.31%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.667mb  | 5.066ms   | ±1.09%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.490mb  | 7.494ms   | ±0.94%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.350mb  | 3.890ms   | ±0.91%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.342mb  | 4.124ms   | ±3.08%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.779mb  | 13.175ms  | ±1.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.394mb  | 3.896ms   | ±2.13%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.675mb  | 2.553ms   | ±0.52%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 693.392μs | ±3.51%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.104mb  | 3.403ms   | ±0.90%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.198mb  | 3.903ms   | ±20.24% |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.119mb  | 3.457ms   | ±2.08%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.175mb  | 217.535ms | ±24.58% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.236mb  | 3.929ms   | ±1.28%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.851mb  | 6.466ms   | ±1.99%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.983mb  | 6.396ms   | ±0.46%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 11.186ms  | ±0.39%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 12.219ms  | ±0.92%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 13.364ms  | ±0.89%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 22.170ms  | ±1.03%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 33.249ms  | ±0.58%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 853.201μs | ±1.21%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 895.320μs | ±1.83%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 989.767μs | ±2.99%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.605ms   | ±11.92% |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.322ms   | ±0.94%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 28.345ms  | ±1.64%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 32.795ms  | ±1.17%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 36.657ms  | ±1.38%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 69.959ms  | ±0.72%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 110.374ms | ±0.72%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 12.410ms  | ±1.00%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 17.400ms  | ±0.55%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 23.511ms  | ±1.55%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 76.984ms  | ±0.42%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 170.359ms | ±1.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.049mb  | 5.316ms   | ±0.98%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.496mb  | 51.479ms  | ±0.72%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.846μs   | ±94.33% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±7.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.678μs   | ±9.07%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 232.196ms | ±8.39%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 478.611μs | ±1.82%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.463mb  | 3.146ms   | ±1.95%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.060mb  | 3.628ms   | ±1.57%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 14.571ms  | ±5.33%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 86.679ms  | ±0.90%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.510ms  | ±1.72%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.197ms  | ±1.22%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.896mb  | 220.436ms | ±17.86% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.288mb  | 14.257ms  | ±0.67%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.261mb  | 14.092ms  | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.269mb  | 14.296ms  | ±0.88%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.285mb  | 14.263ms  | ±0.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.390mb  | 14.588ms  | ±0.51%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.057mb  | 3.354ms   | ±1.21%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.272mb  | 14.058ms  | ±1.64%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.323mb  | 14.063ms  | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.218mb  | 13.715ms  | ±1.52%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.373mb  | 3.582ms   | ±0.85%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.420mb  | 3.731ms   | ±1.02%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.479mb  | 4.065ms   | ±1.01%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.972mb  | 6.056ms   | ±0.58%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.570mb  | 8.827ms   | ±0.76%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 18.498ms  | ±2.40%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 20.008ms  | ±1.22%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 21.315ms  | ±1.00%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 31.160ms  | ±0.19%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 43.869ms  | ±0.65%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.171ms   | ±9.72%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.179ms   | ±1.44%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.293ms   | ±2.33%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.989ms   | ±1.15%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.843ms   | ±0.75%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 42.025μs  | ±0.98%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.506mb  | 254.826μs | ±0.88%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.484mb | 90.023ms  | ±0.62%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.376mb | 383.218ms | ±0.31%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 45.438mb | 1.516s    | ±0.59%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.550mb | 273.768ms | ±1.14%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 32.446mb | 209.032ms | ±0.48%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.293mb | 167.523ms | ±0.53%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.364mb | 228.472ms | ±0.24%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.901mb | 188.870ms | ±0.85%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.455mb | 360.308ms | ±0.41%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.996mb | 56.817ms  | ±0.75%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.912mb | 48.384ms  | ±0.50%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.838mb | 45.828ms  | ±0.33%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.180mb | 149.923ms | ±0.42%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.901mb | 51.953ms  | ±1.13%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 16.119mb | 65.172ms  | ±0.87%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.547mb | 95.078ms  | ±0.53%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.805mb | 41.166ms  | ±2.14%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.742mb | 50.050ms  | ±0.34%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.770mb | 53.147ms  | ±1.37%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.738mb | 50.651ms  | ±0.52%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.826mb | 48.896ms  | ±0.40%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.679mb | 76.844ms  | ±1.26%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.753mb | 47.618ms  | ±1.27%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.405mb | 42.703ms  | ±0.78%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.707mb | 45.871ms  | ±1.03%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.728mb | 51.584ms  | ±0.43%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.721mb | 50.516ms  | ±1.15%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.920mb | 46.678ms  | ±1.06%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 19.157mb | 240.731ms | ±0.32%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.376mb | 177.730ms | ±0.21%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.802mb  | 9.474ms   | ±0.72%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.616mb  | 9.012ms   | ±0.87%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.825mb  | 9.079ms   | ±0.71%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```