# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-02 22:31:33 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.192ms | 2.512ms | 2.752ms | 4.805ms | 7.096ms |
| FPDF | 795.895μs | 836.216μs | 960.694μs | 1.522ms | 2.271ms |
| TCPDF | 9.893ms | 10.913ms | 11.941ms | 20.614ms | 31.005ms |
| mPDF | 24.990ms | 28.900ms | 33.000ms | 65.062ms | 105.276ms |
| Dompdf | 11.356ms | 15.981ms | 21.378ms | 73.529ms | 161.874ms |

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
| phpdftk | 3.299ms | 3.564ms | 3.803ms | 5.770ms | 8.337ms |
| FPDF | 1.038ms | 1.082ms | 1.192ms | 1.879ms | 2.713ms |
| TCPDF | 17.162ms | 18.024ms | 19.381ms | 29.079ms | 41.176ms |

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
| Pdf (Level 3) | 3.389ms | 4.451ms | 12.699ms |
| PdfDoc (Level 2) | 2.740ms | 3.222ms | 7.588ms |
| PdfWriter (Level 1) | 2.329ms | 2.762ms | 6.926ms |

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
| Pdf (Level 3) | 4.353ms | 12.296ms | 46.861ms |
| PdfDoc (Level 2) | 3.917ms | 9.997ms | — |

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
| Pdf (Level 3) | 4.080ms | 11.695ms | 45.002ms |
| PdfDoc (Level 2) | 3.309ms | 7.339ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.040mb | 6.592mb | 9.036mb |
| PdfDoc (Level 2) | 5.829mb | 6.323mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.218ms | 1.687ms | 6.026ms |
| smalot/pdfparser | 2.019ms | 2.383ms | 5.821ms |
| setasign/fpdi | 1.959ms | 2.857ms | 30.009ms |

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
| phpdftk | 2.063ms | 1.379ms |
| smalot/pdfparser | FAIL | 1.931ms |
| setasign/fpdi | 2.990ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.305mb  | 10.312ms  | ±0.88%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.199mb  | 10.321ms  | ±1.22%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.350mb  | 11.898ms  | ±0.40%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.047mb  | 11.988ms  | ±0.24%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.532mb  | 10.977ms  | ±0.24%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.604mb  | 10.557ms  | ±0.73%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.848mb | 19.311ms  | ±0.50%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.752mb  | 3.014ms   | ±0.33%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.040mb  | 4.080ms   | ±0.63%   |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.592mb  | 11.695ms  | ±0.31%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.036mb  | 45.002ms  | ±0.37%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.829mb  | 3.309ms   | ±14.09%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.323mb  | 7.339ms   | ±0.84%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.049μs   | ±16.64%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.919μs   | ±29.99%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.422mb | 16.288ms  | ±0.48%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.422mb | 16.001ms  | ±0.70%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.175mb | 56.819ms  | ±4.13%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.783mb | 115.820ms | ±1.49%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.850mb | 1.401s    | ±0.46%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.241mb | 26.390ms  | ±1.94%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.267mb | 59.651ms  | ±1.78%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.078mb | 522.588ms | ±2.39%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.525mb | 64.579ms  | ±9.50%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.244mb | 86.389ms  | ±1.13%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 33.013mb | 741.520ms | ±0.55%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.289mb | 18.995ms  | ±0.81%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.289mb | 43.569ms  | ±0.66%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.932mb | 325.552ms | ±1.09%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.408mb  | 4.353ms   | ±0.97%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.203mb  | 12.296ms  | ±1.43%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.611mb | 46.861ms  | ±1.08%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.214mb  | 3.917ms   | ±129.40% |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.029mb  | 9.997ms   | ±0.64%   |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.240ms   | ±0.70%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.687ms   | ±0.68%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.026ms   | ±0.40%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.063ms   | ±1.02%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.379ms   | ±1.30%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.019ms   | ±0.89%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.383ms   | ±0.74%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.821ms   | ±1.59%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 560.720μs | ±25.25%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.931ms   | ±0.63%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.959ms   | ±1.39%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.857ms   | ±0.57%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 30.009ms  | ±1.41%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.990ms   | ±0.85%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.533ms   | ±1.00%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.960mb  | 7.365ms   | ±2.46%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.932mb  | 5.526ms   | ±0.86%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.976mb  | 3.915ms   | ±0.51%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.397μs   | ±18.73%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.218ms   | ±0.91%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.498mb  | 26.783ms  | ±0.95%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.667mb | 239.862ms | ±0.78%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.995mb | 1.189s    | ±0.43%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.389mb  | 2.329ms   | ±1.21%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.548mb  | 2.762ms   | ±1.38%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.123mb  | 6.926ms   | ±1.09%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.714mb  | 2.740ms   | ±1.44%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.872mb  | 3.222ms   | ±0.93%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.441mb  | 7.588ms   | ±0.75%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.057mb  | 3.389ms   | ±0.81%   |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.220mb  | 4.451ms   | ±0.35%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.897mb  | 12.699ms  | ±1.18%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.886mb  | 2.294ms   | ±0.96%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.947mb  | 2.512ms   | ±0.32%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.033mb  | 2.752ms   | ±0.58%   |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.667mb  | 4.805ms   | ±1.61%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.490mb  | 7.096ms   | ±0.50%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.350mb  | 3.657ms   | ±1.74%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.342mb  | 3.881ms   | ±2.03%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.779mb  | 12.329ms  | ±1.36%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.394mb  | 3.679ms   | ±0.99%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.675mb  | 2.387ms   | ±0.57%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 766.849μs | ±66.99%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.104mb  | 3.171ms   | ±6.63%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.198mb  | 3.651ms   | ±0.81%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.119mb  | 3.212ms   | ±1.10%   |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.175mb  | 164.097ms | ±19.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.236mb  | 3.587ms   | ±1.20%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.851mb  | 5.818ms   | ±1.78%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.983mb  | 6.087ms   | ±0.74%   |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.893ms   | ±0.44%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.913ms  | ±1.14%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.941ms  | ±0.62%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.614ms  | ±0.25%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.005ms  | ±0.58%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 795.895μs | ±3.43%   |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 836.216μs | ±9.35%   |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 960.694μs | ±0.97%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.522ms   | ±0.96%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.271ms   | ±0.89%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 24.990ms  | ±1.43%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 28.900ms  | ±0.26%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.000ms  | ±0.66%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.062ms  | ±0.74%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 105.276ms | ±0.20%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.356ms  | ±0.92%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.981ms  | ±0.71%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.378ms  | ±0.66%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 73.529ms  | ±0.31%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 161.874ms | ±0.99%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.049mb  | 5.054ms   | ±4.09%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.496mb  | 49.632ms  | ±1.36%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.344μs   | ±11.13%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.665μs   | ±17.39%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 233.300ms | ±31.79%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 451.630μs | ±14.61%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.463mb  | 2.992ms   | ±0.18%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.060mb  | 3.395ms   | ±1.18%   |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 13.609ms  | ±2.56%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 84.517ms  | ±1.04%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.183ms  | ±1.24%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.036ms  | ±3.00%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.896mb  | 252.736ms | ±22.36%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.288mb  | 13.396ms  | ±0.47%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.261mb  | 13.178ms  | ±0.73%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.269mb  | 13.365ms  | ±0.79%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.285mb  | 13.610ms  | ±1.16%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.390mb  | 13.771ms  | ±0.55%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.057mb  | 3.144ms   | ±1.04%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.272mb  | 13.452ms  | ±0.62%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.323mb  | 13.539ms  | ±0.68%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.218mb  | 13.192ms  | ±0.37%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.373mb  | 3.299ms   | ±0.38%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.420mb  | 3.564ms   | ±0.92%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.479mb  | 3.803ms   | ±0.20%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.972mb  | 5.770ms   | ±1.73%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.570mb  | 8.337ms   | ±0.34%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.162ms  | ±0.37%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.024ms  | ±0.69%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.381ms  | ±0.18%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.079ms  | ±0.08%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.176ms  | ±0.54%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.038ms   | ±2.14%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.082ms   | ±0.26%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.192ms   | ±1.10%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.879ms   | ±0.66%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.713ms   | ±0.48%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.603μs  | ±1.71%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.506mb  | 244.049μs | ±0.51%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.476mb | 85.005ms  | ±0.83%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.368mb | 372.158ms | ±0.26%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 45.431mb | 1.453s    | ±0.65%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.540mb | 260.150ms | ±0.86%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 32.049mb | 196.009ms | ±0.80%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.285mb | 160.222ms | ±0.41%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.356mb | 219.011ms | ±0.66%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.893mb | 181.132ms | ±0.24%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.448mb | 349.948ms | ±1.48%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.988mb | 52.052ms  | ±0.34%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.905mb | 45.025ms  | ±0.09%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.830mb | 42.043ms  | ±0.41%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.173mb | 142.615ms | ±1.13%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.893mb | 47.903ms  | ±0.78%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 16.111mb | 60.170ms  | ±0.22%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.539mb | 89.662ms  | ±0.43%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.797mb | 38.145ms  | ±0.17%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.734mb | 46.112ms  | ±0.15%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.762mb | 48.069ms  | ±0.05%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.730mb | 46.695ms  | ±0.93%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.818mb | 45.086ms  | ±0.74%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.671mb | 70.791ms  | ±0.44%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.745mb | 43.874ms  | ±0.63%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.398mb | 39.233ms  | ±0.50%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.699mb | 43.429ms  | ±0.88%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.720mb | 47.964ms  | ±0.70%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.713mb | 47.251ms  | ±0.25%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.913mb | 42.645ms  | ±0.13%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 19.150mb | 226.865ms | ±0.47%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.368mb | 173.897ms | ±1.20%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.802mb  | 8.927ms   | ±0.53%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.616mb  | 8.478ms   | ±0.63%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.825mb  | 8.471ms   | ±0.50%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```