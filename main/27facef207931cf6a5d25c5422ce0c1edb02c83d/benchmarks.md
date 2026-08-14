# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-08-14 14:44:43 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 10.718ms | 2.718ms | 2.495ms | 3.744ms | 5.492ms |
| FPDF | 641.475μs | 692.221μs | 3.184ms | 1.196ms | 1.764ms |
| TCPDF | 8.002ms | 8.672ms | 9.325ms | 15.166ms | 22.485ms |
| mPDF | 21.315ms | 23.113ms | 25.822ms | 47.572ms | 74.059ms |
| Dompdf | 9.092ms | 12.027ms | 15.771ms | 52.634ms | 116.680ms |

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
| phpdftk | 2.753ms | 2.760ms | 2.996ms | 4.607ms | 6.445ms |
| FPDF | 867.104μs | 893.033μs | 992.840μs | 1.533ms | 2.190ms |
| TCPDF | 13.701ms | 14.728ms | 15.121ms | 21.613ms | 30.120ms |

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
| Pdf (Level 3) | 2.669ms | 3.508ms | 9.622ms |
| PdfDoc (Level 2) | 2.111ms | 2.463ms | 5.881ms |
| PdfWriter (Level 1) | 1.811ms | 2.173ms | 5.405ms |

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
| Pdf (Level 3) | 3.434ms | 9.266ms | 42.110ms |
| PdfDoc (Level 2) | 9.807ms | 7.736ms | — |

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
| Pdf (Level 3) | 9.095ms | 9.223ms | 34.995ms |
| PdfDoc (Level 2) | 3.776ms | 5.644ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 4.795ms | 1.295ms | 4.637ms |
| smalot/pdfparser | 1.595ms | 1.846ms | 4.388ms |
| setasign/fpdi | 1.511ms | 2.145ms | 22.254ms |

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
| phpdftk | 1.573ms | 1.040ms |
| smalot/pdfparser | FAIL | 1.510ms |
| setasign/fpdi | 2.244ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.265mb  | 7.602ms   | ±1.82%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.159mb  | 7.762ms   | ±0.84%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.982mb  | 8.965ms   | ±1.77%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.007mb  | 8.834ms   | ±0.47%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.426mb  | 8.485ms   | ±0.44%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.563mb  | 7.690ms   | ±0.92%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.808mb | 13.842ms  | ±1.49%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 2.384ms   | ±1.19%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 9.095ms   | ±121.08% |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 9.223ms   | ±51.40%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 34.995ms  | ±15.17%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.776ms   | ±47.23%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 5.644ms   | ±0.42%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.717μs   | ±25.80%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.885μs   | ±29.12%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 14.641mb | 12.205ms  | ±0.97%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 14.641mb | 12.220ms  | ±0.39%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 15.444mb | 40.725ms  | ±0.82%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.035mb | 82.582ms  | ±1.45%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.899mb | 965.736ms | ±0.51%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.093mb | 20.007ms  | ±26.41%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.119mb | 40.846ms  | ±2.24%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.864mb | 381.199ms | ±0.70%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.376mb | 50.448ms  | ±9.20%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.096mb | 65.609ms  | ±1.03%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.799mb | 523.941ms | ±1.28%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.141mb | 14.513ms  | ±29.05%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.141mb | 32.224ms  | ±0.71%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.783mb | 217.250ms | ±3.39%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 3.434ms   | ±1.22%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 9.266ms   | ±4.73%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 42.110ms  | ±42.36%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 9.807ms   | ±92.91%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 7.736ms   | ±0.74%   |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 971.288μs | ±2.32%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.295ms   | ±1.30%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 4.637ms   | ±0.77%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 1.573ms   | ±0.86%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.040ms   | ±2.07%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.595ms   | ±3.11%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 1.846ms   | ±1.85%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 4.388ms   | ±0.55%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 449.315μs | ±3.63%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.510ms   | ±2.65%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.511ms   | ±0.82%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.145ms   | ±1.76%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 22.254ms  | ±0.73%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.244ms   | ±1.05%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.220ms   | ±1.57%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 5.576ms   | ±2.20%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 4.164ms   | ±0.35%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.060ms   | ±1.09%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.297μs   | ±20.20%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 4.795ms   | ±0.28%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.426mb  | 18.792ms  | ±0.74%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.434mb | 167.277ms | ±0.88%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.052mb | 814.122ms | ±1.19%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 1.811ms   | ±1.50%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.173ms   | ±1.71%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 5.405ms   | ±0.91%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.111ms   | ±8.55%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 2.463ms   | ±0.76%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 5.881ms   | ±3.96%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 2.669ms   | ±25.06%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 3.508ms   | ±90.32%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 9.622ms   | ±0.75%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 1.798ms   | ±7.53%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.718ms   | ±83.60%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.495ms   | ±64.33%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 3.744ms   | ±0.50%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 5.492ms   | ±1.61%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 2.786ms   | ±82.29%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.047ms   | ±117.90% |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 10.084ms  | ±46.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 2.854ms   | ±0.81%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 1.867ms   | ±124.48% |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 504.845μs | ±98.45%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 2.481ms   | ±0.90%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.668ms   | ±90.04%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 2.541ms   | ±64.61%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 162.700ms | ±29.08%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 2.765ms   | ±32.52%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.077ms   | ±51.88%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 4.690ms   | ±21.88%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 8.002ms   | ±3.29%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 8.672ms   | ±2.20%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 9.325ms   | ±1.84%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 15.166ms  | ±0.55%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 22.485ms  | ±0.64%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 641.475μs | ±3.64%   |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 692.221μs | ±161.57% |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 3.184ms   | ±63.67%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.196ms   | ±0.61%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 1.764ms   | ±0.77%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 21.315ms  | ±64.88%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 23.113ms  | ±1.58%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 25.822ms  | ±1.09%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 47.572ms  | ±1.11%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 74.059ms  | ±0.55%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 9.092ms   | ±1.97%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 12.027ms  | ±1.81%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 15.771ms  | ±1.18%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 52.634ms  | ±0.51%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 116.680ms | ±0.77%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 3.944ms   | ±12.56%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 41.457ms  | ±0.67%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.344μs   | ±11.13%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.142μs   | ±22.36%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 148.164ms | ±21.16%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 383.794μs | ±1.17%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.271ms   | ±0.12%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 2.731ms   | ±41.10%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 10.421ms  | ±37.92%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 63.436ms  | ±0.45%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 12.060ms  | ±5.38%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 19.920ms  | ±2.70%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 161.790ms | ±18.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 10.993ms  | ±44.80%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 14.055ms  | ±74.48%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 11.029ms  | ±44.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 11.174ms  | ±0.91%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 11.323ms  | ±0.74%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 2.470ms   | ±1.58%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 10.922ms  | ±1.02%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 10.933ms  | ±4.59%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 10.718ms  | ±0.32%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 2.753ms   | ±36.98%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 2.760ms   | ±0.28%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 2.996ms   | ±1.42%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 4.607ms   | ±0.60%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 6.445ms   | ±0.71%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 13.701ms  | ±0.27%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 14.728ms  | ±3.39%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 15.121ms  | ±0.99%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 21.613ms  | ±0.22%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 30.120ms  | ±0.59%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 867.104μs | ±3.21%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 893.033μs | ±4.44%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 992.840μs | ±2.02%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.533ms   | ±4.69%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.190ms   | ±2.44%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 33.479μs  | ±1.30%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 184.970μs | ±2.44%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 15.669mb | 60.054ms  | ±1.11%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.844mb | 253.325ms | ±0.50%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.507mb | 989.119ms | ±0.78%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.034mb | 179.616ms | ±0.41%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.617mb | 146.126ms | ±0.39%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 16.454mb | 114.912ms | ±0.80%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 17.504mb | 152.631ms | ±0.71%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.119mb | 124.676ms | ±0.77%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 19.614mb | 238.373ms | ±1.97%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.192mb | 37.286ms  | ±0.71%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.112mb | 32.363ms  | ±1.19%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.041mb | 31.518ms  | ±0.55%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.342mb | 99.032ms  | ±0.27%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.101mb | 33.877ms  | ±0.16%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.312mb | 42.833ms  | ±0.68%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 15.729mb | 62.660ms  | ±0.50%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.008mb | 27.607ms  | ±0.89%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.010mb | 33.397ms  | ±0.33%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.038mb | 35.485ms  | ±0.65%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.007mb | 34.464ms  | ±0.46%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.029mb | 32.768ms  | ±0.17%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.271mb | 53.280ms  | ±0.44%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.324mb | 33.562ms  | ±0.35%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.000mb | 28.580ms  | ±0.63%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.975mb | 31.232ms  | ±0.33%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.996mb | 35.893ms  | ±0.59%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.989mb | 35.126ms  | ±0.30%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.492mb | 33.253ms  | ±0.39%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.361mb | 159.791ms | ±0.42%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 15.573mb | 125.963ms | ±0.07%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 6.856ms   | ±1.18%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 6.714ms   | ±125.61% |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 6.579ms   | ±0.59%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```