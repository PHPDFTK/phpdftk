# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-01 16:32:25 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.943ms | 2.031ms | 2.134ms | 3.751ms | 5.399ms |
| FPDF | 650.688μs | 730.213μs | 4.108ms | 1.190ms | 1.759ms |
| TCPDF | 7.875ms | 10.627ms | 9.263ms | 15.624ms | 25.822ms |
| mPDF | 20.170ms | 34.263ms | 31.548ms | 47.600ms | 73.589ms |
| Dompdf | 8.684ms | 11.886ms | 16.944ms | 52.334ms | 117.037ms |

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
| phpdftk | 11.388ms | 2.751ms | 7.535ms | 4.480ms | 9.238ms |
| FPDF | 8.008ms | 873.778μs | 2.852ms | 1.483ms | 2.166ms |
| TCPDF | 13.302ms | 14.611ms | 14.949ms | 21.385ms | 29.995ms |

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
| Pdf (Level 3) | 3.817ms | 3.475ms | 9.423ms |
| PdfDoc (Level 2) | 3.399ms | 2.489ms | 5.780ms |
| PdfWriter (Level 1) | 1.956ms | 2.193ms | 6.475ms |

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
| Pdf (Level 3) | 3.398ms | 9.291ms | 35.783ms |
| PdfDoc (Level 2) | 2.873ms | 7.715ms | — |

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
| Pdf (Level 3) | 13.791ms | 9.009ms | 34.519ms |
| PdfDoc (Level 2) | 2.517ms | 5.665ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 4.721ms | 1.279ms | 4.699ms |
| smalot/pdfparser | 1.538ms | 1.815ms | 4.275ms |
| setasign/fpdi | 1.455ms | 2.088ms | 22.472ms |

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
| phpdftk | 1.560ms | 1.037ms |
| smalot/pdfparser | FAIL | 1.498ms |
| setasign/fpdi | 2.219ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 7.529ms   | ±0.98%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 7.586ms   | ±2.92%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 8.780ms   | ±0.87%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 8.710ms   | ±1.41%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 8.567ms   | ±1.68%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 7.628ms   | ±0.42%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 13.563ms  | ±0.94%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 2.377ms   | ±0.59%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 13.791ms  | ±79.63%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 9.009ms   | ±10.74%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 34.519ms  | ±0.40%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 2.517ms   | ±0.65%   |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 5.665ms   | ±72.00%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.776μs   | ±25.40%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.008μs   | ±32.66%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.234mb | 12.334ms  | ±0.40%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.234mb | 12.465ms  | ±1.34%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.037mb | 41.715ms  | ±15.28%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.628mb | 88.177ms  | ±17.35%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.279mb | 965.116ms | ±0.63%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.200mb | 18.415ms  | ±2.58%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.226mb | 40.162ms  | ±1.42%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.037mb | 363.339ms | ±0.64%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.483mb | 59.964ms  | ±19.01%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.203mb | 63.843ms  | ±1.13%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.972mb | 515.125ms | ±1.36%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.248mb | 13.745ms  | ±0.68%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.248mb | 31.866ms  | ±0.29%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.890mb | 215.815ms | ±0.68%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 3.398ms   | ±77.93%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 9.291ms   | ±5.27%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 35.783ms  | ±0.81%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 2.873ms   | ±0.44%   |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 7.715ms   | ±13.28%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 933.856μs | ±0.96%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.279ms   | ±0.63%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 4.699ms   | ±0.57%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 1.560ms   | ±0.39%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.037ms   | ±1.19%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 1.538ms   | ±0.74%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 1.815ms   | ±0.56%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 4.275ms   | ±1.10%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 432.177μs | ±0.57%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.498ms   | ±1.09%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.455ms   | ±1.24%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.088ms   | ±0.46%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 22.472ms  | ±0.36%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.219ms   | ±0.29%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.179ms   | ±0.41%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 5.451ms   | ±0.39%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 4.132ms   | ±4.19%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 2.973ms   | ±2.04%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.109μs   | ±23.57%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 4.721ms   | ±0.66%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.462mb  | 21.582ms  | ±6.65%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.470mb | 172.800ms | ±8.07%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.088mb | 827.177ms | ±8.64%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 1.956ms   | ±183.09% |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.193ms   | ±124.11% |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.475ms   | ±89.22%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 3.399ms   | ±99.01%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 2.489ms   | ±147.68% |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 5.780ms   | ±0.79%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.817ms   | ±92.27%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 3.475ms   | ±115.71% |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 9.423ms   | ±0.31%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 1.813ms   | ±3.09%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.031ms   | ±153.55% |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.134ms   | ±26.90%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 3.751ms   | ±79.25%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 5.399ms   | ±1.89%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 2.743ms   | ±0.41%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 2.916ms   | ±28.44%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 10.028ms  | ±8.67%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 2.985ms   | ±106.02% |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 1.828ms   | ±57.59%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 479.331μs | ±4.40%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 2.547ms   | ±164.93% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 2.780ms   | ±1.86%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 2.460ms   | ±1.15%   |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 168.606ms | ±36.61%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 2.758ms   | ±92.50%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 4.463ms   | ±24.31%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 5.456ms   | ±105.08% |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 7.875ms   | ±85.41%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.627ms  | ±81.15%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 9.263ms   | ±0.88%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 15.624ms  | ±21.90%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 25.822ms  | ±54.24%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 650.688μs | ±168.12% |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 730.213μs | ±184.02% |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 4.108ms   | ±150.90% |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.190ms   | ±1.13%   |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 1.759ms   | ±1.15%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 20.170ms  | ±61.55%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 34.263ms  | ±108.06% |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 31.548ms  | ±88.58%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 47.600ms  | ±8.66%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 73.589ms  | ±13.98%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 8.684ms   | ±60.13%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 11.886ms  | ±70.75%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 16.944ms  | ±40.06%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 52.334ms  | ±1.22%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 117.037ms | ±7.01%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 3.840ms   | ±38.26%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 41.822ms  | ±2.08%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.624μs   | ±18.18%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.624μs   | ±18.18%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.333μs   | ±15.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 234.019ms | ±26.03%  |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 377.084μs | ±1.43%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 2.258ms   | ±0.30%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 4.691ms   | ±109.25% |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 14.592ms  | ±59.82%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 63.971ms  | ±1.33%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 11.739ms  | ±0.84%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 20.330ms  | ±1.52%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 236.484ms | ±21.53%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 10.931ms  | ±0.31%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 10.741ms  | ±3.78%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 34.192ms  | ±33.46%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.956ms  | ±51.95%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 11.222ms  | ±48.77%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.249ms   | ±81.46%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 11.150ms  | ±129.27% |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 10.805ms  | ±0.96%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.943ms  | ±81.11%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 11.388ms  | ±134.38% |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 2.751ms   | ±0.69%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 7.535ms   | ±126.96% |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 4.480ms   | ±0.90%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 9.238ms   | ±101.11% |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 13.302ms  | ±0.40%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 14.611ms  | ±23.12%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 14.949ms  | ±0.51%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 21.385ms  | ±0.43%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 29.995ms  | ±7.90%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 8.008ms   | ±138.54% |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 873.778μs | ±0.55%   |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 2.852ms   | ±129.70% |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.483ms   | ±1.19%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.166ms   | ±0.28%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 33.492μs  | ±0.83%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 182.841μs | ±0.99%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.327mb | 63.204ms  | ±3.04%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.158mb | 255.103ms | ±0.20%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.821mb | 1.011s    | ±0.78%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.389mb | 181.524ms | ±0.20%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.945mb | 146.685ms | ±1.63%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.112mb | 114.173ms | ±0.83%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.163mb | 154.619ms | ±4.30%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.712mb | 128.321ms | ±2.99%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.207mb | 240.021ms | ±0.50%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.851mb | 37.073ms  | ±0.08%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.770mb | 32.473ms  | ±3.45%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.699mb | 31.859ms  | ±2.29%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 16.935mb | 100.290ms | ±1.72%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.759mb | 34.511ms  | ±2.53%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.971mb | 43.469ms  | ±2.82%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.387mb | 64.477ms  | ±4.34%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.666mb | 27.823ms  | ±3.58%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.603mb | 34.086ms  | ±0.59%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.631mb | 38.853ms  | ±4.82%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.599mb | 34.442ms  | ±0.61%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.622mb | 33.704ms  | ±0.87%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.585mb | 54.704ms  | ±1.20%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.639mb | 33.243ms  | ±1.97%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.315mb | 28.883ms  | ±1.42%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.568mb | 31.472ms  | ±0.47%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.589mb | 35.926ms  | ±3.09%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.582mb | 35.437ms  | ±2.57%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.806mb | 32.334ms  | ±0.45%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.954mb | 159.111ms | ±0.46%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.231mb | 125.441ms | ±0.91%   |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 6.785ms   | ±31.19%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 6.498ms   | ±1.83%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 7.356ms   | ±96.15%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```