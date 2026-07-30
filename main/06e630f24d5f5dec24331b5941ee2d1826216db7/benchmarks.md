# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-30 14:27:14 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.393ms | 2.534ms | 2.763ms | 4.825ms | 7.143ms |
| FPDF | 826.978μs | 851.584μs | 927.046μs | 1.523ms | 2.253ms |
| TCPDF | 9.910ms | 10.920ms | 11.942ms | 20.660ms | 31.337ms |
| mPDF | 25.982ms | 29.079ms | 33.150ms | 65.238ms | 104.992ms |
| Dompdf | 11.304ms | 15.942ms | 21.766ms | 73.566ms | 161.635ms |

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
| phpdftk | 3.404ms | 3.558ms | 3.823ms | 5.912ms | 8.273ms |
| FPDF | 1.031ms | 1.140ms | 1.205ms | 1.907ms | 2.746ms |
| TCPDF | 17.169ms | 18.263ms | 19.438ms | 29.234ms | 41.188ms |

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
| Pdf (Level 3) | 3.414ms | 4.479ms | 12.626ms |
| PdfDoc (Level 2) | 2.722ms | 3.180ms | 7.541ms |
| PdfWriter (Level 1) | 2.346ms | 2.803ms | 6.956ms |

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
| Pdf (Level 3) | 4.407ms | 12.175ms | 46.837ms |
| PdfDoc (Level 2) | 3.849ms | 10.058ms | — |

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
| Pdf (Level 3) | 4.076ms | 11.859ms | 46.230ms |
| PdfDoc (Level 2) | 3.339ms | 7.392ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.281ms | 1.670ms | 5.967ms |
| smalot/pdfparser | 2.051ms | 2.452ms | 5.766ms |
| setasign/fpdi | 1.941ms | 2.827ms | 29.513ms |

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
| phpdftk | 2.024ms | 1.386ms |
| smalot/pdfparser | FAIL | 1.945ms |
| setasign/fpdi | 2.965ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.032ms   | ±0.82%   |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.566ms   | ±7.56%   |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.666ms   | ±0.55%   |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.215mb  | 10.015ms  | ±0.50%   |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.087mb  | 10.063ms  | ±0.71%   |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.913mb  | 11.718ms  | ±0.08%   |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.957mb  | 11.766ms  | ±0.19%   |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.376mb  | 11.096ms  | ±0.48%   |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.514mb  | 10.137ms  | ±0.37%   |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.756mb | 19.252ms  | ±0.41%   |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.731mb  | 3.007ms   | ±1.20%   |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.279mb  | 24.135ms  | ±0.17%   |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.264mb | 215.116ms | ±0.63%   |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.780mb | 1.066s    | ±0.27%   |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.766μs   | ±21.60%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.085μs   | ±26.76%  |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.878mb | 15.196ms  | ±6.32%   |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.878mb | 14.943ms  | ±1.00%   |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.370ms   | ±5.08%   |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.534ms   | ±0.62%   |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.763ms   | ±1.56%   |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.825ms   | ±0.83%   |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.143ms   | ±0.48%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.609ms   | ±6.21%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.872ms   | ±0.38%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.284ms  | ±15.73%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.648ms   | ±0.78%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.420ms   | ±0.72%   |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 828.628μs | ±190.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.198ms   | ±0.50%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.672ms   | ±0.70%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.240ms   | ±1.02%   |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 143.139ms | ±40.47%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.619ms   | ±1.07%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.806ms   | ±65.79%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.014ms   | ±0.78%   |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 9.910ms   | ±7.32%   |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 10.920ms  | ±0.20%   |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 11.942ms  | ±0.42%   |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.660ms  | ±0.60%   |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.337ms  | ±0.76%   |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 826.978μs | ±3.07%   |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 851.584μs | ±2.36%   |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 927.046μs | ±3.82%   |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.523ms   | ±16.31%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.253ms   | ±0.62%   |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.982ms  | ±8.04%   |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.079ms  | ±1.48%   |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.150ms  | ±1.59%   |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.238ms  | ±0.45%   |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 104.992ms | ±1.25%   |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.304ms  | ±3.95%   |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 15.942ms  | ±0.62%   |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.766ms  | ±0.65%   |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 73.566ms  | ±0.77%   |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 161.635ms | ±0.47%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.145ms   | ±0.92%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.103ms  | ±0.93%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.334μs   | ±9.52%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.344μs   | ±11.13%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 179.105ms | ±9.66%   |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 457.735μs | ±0.52%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.027ms   | ±1.25%   |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.424ms   | ±0.81%   |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 12.819ms  | ±4.70%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 87.977ms  | ±0.89%   |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.846ms  | ±5.14%   |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.114ms  | ±0.31%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 168.598ms | ±19.60%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.514ms  | ±0.50%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.481ms  | ±1.09%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.435ms  | ±0.38%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.624ms  | ±0.82%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 13.874ms  | ±0.69%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.191ms   | ±0.47%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.572ms  | ±0.83%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.657ms  | ±0.58%   |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.393ms  | ±1.14%   |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.240ms   | ±1.36%   |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.670ms   | ±0.90%   |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.967ms   | ±0.75%   |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.024ms   | ±0.70%   |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.386ms   | ±1.29%   |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.051ms   | ±0.96%   |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.452ms   | ±1.50%   |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.766ms   | ±1.74%   |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 559.539μs | ±1.18%   |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.945ms   | ±0.71%   |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.941ms   | ±0.89%   |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.827ms   | ±1.21%   |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.513ms  | ±0.63%   |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.965ms   | ±1.55%   |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.522ms   | ±0.61%   |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.322ms   | ±0.24%   |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.445ms   | ±1.11%   |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.857ms   | ±0.89%   |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.212μs   | ±2.89%   |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.281ms   | ±1.01%   |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.614mb | 52.009ms  | ±0.45%   |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 15.202mb | 108.674ms | ±0.85%   |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.393mb | 1.287s    | ±0.43%   |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.818mb | 26.227ms  | ±1.18%   |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.844mb | 57.970ms  | ±0.51%   |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.590mb | 544.777ms | ±0.24%   |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.101mb | 63.430ms  | ±8.80%   |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.755mb | 86.358ms  | ±0.81%   |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.524mb | 731.937ms | ±0.72%   |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.866mb | 21.482ms  | ±0.43%   |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.866mb | 46.016ms  | ±0.45%   |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.508mb | 325.337ms | ±0.29%   |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.166μs  | ±2.52%   |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 242.599μs | ±1.04%   |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.407ms   | ±0.78%   |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.175ms  | ±3.26%   |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 46.837ms  | ±0.56%   |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.849ms   | ±0.86%   |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.058ms  | ±0.93%   |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.902mb | 77.808ms  | ±0.53%   |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.297mb | 338.154ms | ±0.43%   |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 43.917mb | 1.325s    | ±0.35%   |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.840mb | 238.438ms | ±0.82%   |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.144mb | 188.469ms | ±0.62%   |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.689mb | 149.453ms | ±0.60%   |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.725mb | 203.229ms | ±0.38%   |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 16.283mb | 166.180ms | ±0.36%   |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.761mb | 314.320ms | ±0.40%   |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 14.429mb | 48.375ms  | ±0.12%   |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 14.348mb | 42.260ms  | ±1.37%   |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 14.277mb | 39.775ms  | ±0.06%   |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 15.578mb | 132.224ms | ±1.00%   |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 14.337mb | 44.505ms  | ±1.13%   |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 14.549mb | 55.536ms  | ±0.73%   |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 14.965mb | 82.226ms  | ±0.57%   |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 14.244mb | 35.189ms  | ±1.72%   |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 14.496mb | 43.580ms  | ±0.60%   |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 14.274mb | 45.063ms  | ±1.45%   |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 14.352mb | 44.160ms  | ±0.30%   |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 14.265mb | 42.352ms  | ±0.59%   |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 29.815mb | 119.415ms | ±0.49%   |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 16.792mb | 41.920ms  | ±0.71%   |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 15.545mb | 37.276ms  | ±1.18%   |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.212mb | 40.267ms  | ±3.26%   |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.285mb | 45.560ms  | ±1.11%   |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.226mb | 44.968ms  | ±1.51%   |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 17.959mb | 40.784ms  | ±0.90%   |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.526mb | 212.355ms | ±1.27%   |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.808mb | 165.631ms | ±0.42%   |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.076ms   | ±0.78%   |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.859ms  | ±0.69%   |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 46.230ms  | ±0.59%   |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.339ms   | ±3.70%   |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.392ms   | ±0.47%   |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.346ms   | ±3.25%   |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.803ms   | ±0.89%   |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.956ms   | ±0.55%   |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.722ms   | ±0.95%   |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.180ms   | ±1.03%   |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.541ms   | ±1.24%   |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.414ms   | ±0.75%   |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.479ms   | ±1.12%   |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.626ms  | ±0.78%   |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.404ms   | ±4.35%   |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.558ms   | ±0.59%   |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.823ms   | ±0.40%   |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.912ms   | ±1.01%   |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.273ms   | ±0.61%   |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.169ms  | ±0.29%   |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.263ms  | ±0.98%   |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.438ms  | ±0.48%   |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.234ms  | ±0.15%   |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.188ms  | ±0.19%   |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.031ms   | ±2.61%   |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.140ms   | ±12.70%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.205ms   | ±0.18%   |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.907ms   | ±0.83%   |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.746ms   | ±1.03%   |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+----------+

```