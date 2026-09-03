# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-03 23:47:13 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.196ms | 2.480ms | 2.747ms | 4.764ms | 6.955ms |
| FPDF | 819.202μs | 849.004μs | 922.528μs | 1.481ms | 2.238ms |
| TCPDF | 9.802ms | 10.839ms | 11.950ms | 20.357ms | 30.774ms |
| mPDF | 25.039ms | 28.727ms | 32.818ms | 65.098ms | 104.368ms |
| Dompdf | 11.191ms | 15.735ms | 21.305ms | 72.131ms | 161.409ms |

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
| phpdftk | 3.307ms | 3.531ms | 3.776ms | 5.821ms | 8.361ms |
| FPDF | 1.044ms | 1.124ms | 1.195ms | 1.881ms | 2.725ms |
| TCPDF | 16.940ms | 18.375ms | 19.266ms | 29.006ms | 41.853ms |

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
| Pdf (Level 3) | 3.401ms | 4.411ms | 12.570ms |
| PdfDoc (Level 2) | 2.690ms | 3.154ms | 7.533ms |
| PdfWriter (Level 1) | 2.301ms | 2.755ms | 6.893ms |

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
| Pdf (Level 3) | 4.311ms | 12.023ms | 46.091ms |
| PdfDoc (Level 2) | 3.758ms | 9.916ms | — |

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
| Pdf (Level 3) | 4.049ms | 11.595ms | 45.102ms |
| PdfDoc (Level 2) | 3.258ms | 7.270ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.040mb | 6.592mb | 9.036mb |
| PdfDoc (Level 2) | 5.829mb | 6.323mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.202ms | 1.660ms | 5.927ms |
| smalot/pdfparser | 1.967ms | 2.342ms | 5.733ms |
| setasign/fpdi | 1.911ms | 2.815ms | 29.818ms |

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
| phpdftk | 2.009ms | 1.344ms |
| smalot/pdfparser | FAIL | 1.887ms |
| setasign/fpdi | 2.956ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.308mb  | 13.364ms  | ±14.06% |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.202mb  | 10.283ms  | ±0.55%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.353mb  | 11.712ms  | ±0.42%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.050mb  | 12.167ms  | ±0.17%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.535mb  | 10.837ms  | ±0.61%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.607mb  | 10.164ms  | ±0.99%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.851mb | 19.314ms  | ±0.87%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.752mb  | 2.985ms   | ±0.87%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.040mb  | 4.049ms   | ±0.64%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.592mb  | 11.595ms  | ±0.31%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.036mb  | 45.102ms  | ±2.45%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.829mb  | 3.258ms   | ±1.81%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.323mb  | 7.270ms   | ±1.13%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.036μs   | ±12.86% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.085μs   | ±26.76% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.437mb | 16.084ms  | ±0.69%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.437mb | 16.060ms  | ±1.44%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.189mb | 56.804ms  | ±0.54%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.797mb | 115.719ms | ±0.82%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.865mb | 1.416s    | ±0.61%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.253mb | 25.751ms  | ±3.57%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.280mb | 57.530ms  | ±0.46%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.091mb | 526.302ms | ±0.92%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.537mb | 64.434ms  | ±8.74%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.257mb | 90.423ms  | ±21.42% |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 33.025mb | 727.126ms | ±0.64%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.302mb | 18.550ms  | ±0.17%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.302mb | 42.857ms  | ±1.07%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.944mb | 319.424ms | ±0.22%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.408mb  | 4.311ms   | ±0.83%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.203mb  | 12.023ms  | ±0.98%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.611mb | 46.091ms  | ±0.39%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.214mb  | 3.758ms   | ±0.75%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.029mb  | 9.916ms   | ±0.41%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.219ms   | ±1.04%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.660ms   | ±2.00%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.927ms   | ±0.73%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.009ms   | ±0.81%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.344ms   | ±0.58%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.967ms   | ±0.95%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.342ms   | ±0.99%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.733ms   | ±0.78%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 535.114μs | ±1.35%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.887ms   | ±0.92%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.911ms   | ±0.85%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.815ms   | ±0.94%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.818ms  | ±0.44%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.956ms   | ±0.56%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.535ms   | ±1.19%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.960mb  | 7.196ms   | ±1.09%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.932mb  | 5.422ms   | ±0.61%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.976mb  | 3.943ms   | ±0.16%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.819μs   | ±20.75% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.202ms   | ±1.10%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.503mb  | 26.331ms  | ±0.69%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.671mb | 239.498ms | ±0.75%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.999mb | 1.186s    | ±1.93%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.389mb  | 2.301ms   | ±1.29%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.548mb  | 2.755ms   | ±1.50%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.123mb  | 6.893ms   | ±1.05%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.714mb  | 2.690ms   | ±1.24%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.872mb  | 3.154ms   | ±1.17%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.441mb  | 7.533ms   | ±2.90%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.057mb  | 3.401ms   | ±1.30%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.220mb  | 4.411ms   | ±0.96%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.897mb  | 12.570ms  | ±0.65%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.886mb  | 2.322ms   | ±1.35%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.947mb  | 2.480ms   | ±0.91%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.033mb  | 2.747ms   | ±1.05%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.667mb  | 4.764ms   | ±1.64%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.490mb  | 6.955ms   | ±0.97%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.350mb  | 3.527ms   | ±0.79%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.342mb  | 3.831ms   | ±1.12%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.779mb  | 12.268ms  | ±14.36% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.394mb  | 3.580ms   | ±1.51%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.675mb  | 2.374ms   | ±0.66%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 640.881μs | ±4.22%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.104mb  | 3.158ms   | ±0.31%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.198mb  | 3.635ms   | ±0.96%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.119mb  | 3.205ms   | ±0.83%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.175mb  | 154.002ms | ±28.14% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.236mb  | 3.577ms   | ±0.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.851mb  | 5.764ms   | ±27.29% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.983mb  | 5.992ms   | ±0.96%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.802ms   | ±0.93%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.839ms  | ±0.86%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.950ms  | ±1.79%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.357ms  | ±0.62%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 30.774ms  | ±0.33%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 819.202μs | ±3.89%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 849.004μs | ±1.61%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 922.528μs | ±9.31%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.481ms   | ±1.47%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.238ms   | ±0.26%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.039ms  | ±1.76%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.727ms  | ±0.82%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 32.818ms  | ±0.37%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.098ms  | ±0.60%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 104.368ms | ±0.65%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.191ms  | ±0.98%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.735ms  | ±0.49%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.305ms  | ±0.99%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 72.131ms  | ±0.54%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 161.409ms | ±0.37%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.049mb  | 5.008ms   | ±0.36%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.496mb  | 49.922ms  | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.624μs   | ±18.18% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.344μs   | ±89.32% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 156.147ms | ±23.37% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 454.607μs | ±1.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.463mb  | 3.003ms   | ±0.16%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.060mb  | 3.362ms   | ±0.82%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 12.808ms  | ±6.97%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 85.671ms  | ±1.77%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.211ms  | ±8.07%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 24.766ms  | ±1.60%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.896mb  | 200.296ms | ±22.43% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.288mb  | 13.430ms  | ±0.23%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.261mb  | 13.283ms  | ±1.25%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.269mb  | 13.299ms  | ±0.45%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.285mb  | 13.529ms  | ±0.35%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.390mb  | 13.887ms  | ±0.49%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.057mb  | 3.161ms   | ±1.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.272mb  | 13.465ms  | ±0.45%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.323mb  | 13.437ms  | ±0.51%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.218mb  | 13.196ms  | ±0.66%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.373mb  | 3.307ms   | ±1.19%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.420mb  | 3.531ms   | ±0.27%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.479mb  | 3.776ms   | ±0.73%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.972mb  | 5.821ms   | ±0.46%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.570mb  | 8.361ms   | ±1.44%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 16.940ms  | ±1.08%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.375ms  | ±1.13%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.266ms  | ±0.30%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.006ms  | ±0.10%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.853ms  | ±0.77%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.044ms   | ±2.64%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.124ms   | ±1.82%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.195ms   | ±2.47%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.881ms   | ±0.87%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.725ms   | ±0.96%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.305μs  | ±0.51%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.506mb  | 241.248μs | ±0.74%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.490mb | 85.594ms  | ±0.67%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.382mb | 372.390ms | ±0.65%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 45.445mb | 1.460s    | ±1.36%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.556mb | 259.893ms | ±0.49%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 32.453mb | 196.166ms | ±0.09%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.300mb | 160.877ms | ±0.26%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.371mb | 222.665ms | ±0.77%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.907mb | 183.882ms | ±1.33%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.462mb | 349.167ms | ±0.45%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 16.002mb | 51.797ms  | ±1.23%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.919mb | 45.136ms  | ±1.09%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.845mb | 42.375ms  | ±0.37%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.187mb | 142.342ms | ±0.51%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.908mb | 47.253ms  | ±0.06%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 16.125mb | 60.382ms  | ±0.21%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.554mb | 89.779ms  | ±0.39%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.811mb | 38.153ms  | ±0.65%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.749mb | 46.240ms  | ±0.50%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.776mb | 47.935ms  | ±0.08%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.745mb | 46.500ms  | ±0.74%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.833mb | 44.830ms  | ±0.51%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.685mb | 71.256ms  | ±0.20%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.759mb | 43.820ms  | ±0.48%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.412mb | 39.233ms  | ±0.86%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.713mb | 43.348ms  | ±0.59%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.734mb | 47.607ms  | ±0.16%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.727mb | 47.383ms  | ±0.43%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.927mb | 42.614ms  | ±1.69%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 19.164mb | 228.919ms | ±0.19%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.383mb | 169.507ms | ±0.32%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.802mb  | 8.853ms   | ±0.28%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.616mb  | 8.352ms   | ±0.43%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.825mb  | 8.477ms   | ±0.49%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```