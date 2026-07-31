# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-31 04:10:47 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.426ms | 2.586ms | 2.810ms | 4.848ms | 7.219ms |
| FPDF | 785.297μs | 841.655μs | 950.318μs | 1.546ms | 2.292ms |
| TCPDF | 10.325ms | 11.106ms | 12.136ms | 20.883ms | 31.674ms |
| mPDF | 25.566ms | 29.573ms | 33.699ms | 65.796ms | 106.760ms |
| Dompdf | 11.580ms | 16.355ms | 21.953ms | 75.034ms | 165.124ms |

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
| phpdftk | 3.421ms | 3.657ms | 3.919ms | 6.044ms | 8.548ms |
| FPDF | 1.094ms | 1.136ms | 1.227ms | 1.920ms | 2.760ms |
| TCPDF | 18.043ms | 18.449ms | 19.789ms | 29.821ms | 41.793ms |

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
| Pdf (Level 3) | 3.409ms | 4.600ms | 12.782ms |
| PdfDoc (Level 2) | 2.754ms | 3.291ms | 7.780ms |
| PdfWriter (Level 1) | 2.364ms | 2.841ms | 7.114ms |

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
| Pdf (Level 3) | 4.502ms | 12.309ms | 47.555ms |
| PdfDoc (Level 2) | 3.865ms | 10.183ms | — |

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
| Pdf (Level 3) | 4.186ms | 11.893ms | 45.734ms |
| PdfDoc (Level 2) | 3.371ms | 7.503ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.219ms | 1.712ms | 5.947ms |
| smalot/pdfparser | 2.072ms | 2.428ms | 5.904ms |
| setasign/fpdi | 1.974ms | 2.884ms | 30.030ms |

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
| phpdftk | 2.039ms | 1.418ms |
| smalot/pdfparser | FAIL | 1.972ms |
| setasign/fpdi | 3.029ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.263ms   | ±1.24%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.705ms   | ±0.49%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.810ms   | ±0.56%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.215mb  | 10.236ms  | ±0.35%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.087mb  | 10.197ms  | ±0.71%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.913mb  | 11.831ms  | ±0.52%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.957mb  | 11.932ms  | ±0.83%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.376mb  | 10.991ms  | ±0.59%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.514mb  | 10.420ms  | ±0.73%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.756mb | 19.591ms  | ±0.25%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.731mb  | 3.155ms   | ±2.05%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.279mb  | 24.633ms  | ±0.75%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.264mb | 219.597ms | ±1.12%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.780mb | 1.072s    | ±0.64%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.024μs   | ±8.84%  |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.121μs   | ±35.36% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.887mb | 15.214ms  | ±0.72%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.887mb | 15.229ms  | ±0.77%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.366ms   | ±1.51%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.586ms   | ±1.04%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.810ms   | ±10.35% |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.848ms   | ±0.73%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.219ms   | ±0.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.663ms   | ±1.02%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.947ms   | ±1.06%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.561ms  | ±1.07%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.711ms   | ±1.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.445ms   | ±0.84%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 667.837μs | ±3.74%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.319ms   | ±0.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.710ms   | ±1.65%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.314ms   | ±0.87%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 195.548ms | ±10.98% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.639ms   | ±1.31%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.948ms   | ±31.56% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.230ms   | ±1.06%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.325ms  | ±1.36%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.106ms  | ±0.54%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.136ms  | ±1.42%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 20.883ms  | ±0.41%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.674ms  | ±0.17%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 785.297μs | ±1.59%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 841.655μs | ±0.85%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 950.318μs | ±1.61%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.546ms   | ±0.93%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.292ms   | ±0.71%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.566ms  | ±2.44%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.573ms  | ±0.67%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 33.699ms  | ±0.54%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 65.796ms  | ±1.22%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 106.760ms | ±0.54%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.580ms  | ±4.36%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.355ms  | ±0.52%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 21.953ms  | ±6.99%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 75.034ms  | ±2.87%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 165.124ms | ±0.43%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.135ms   | ±0.86%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.983ms  | ±0.60%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.344μs   | ±11.13% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 238.537ms | ±40.47% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 465.523μs | ±1.93%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.045ms   | ±0.37%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.495ms   | ±1.09%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 14.180ms  | ±5.94%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 87.339ms  | ±1.61%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 15.116ms  | ±2.22%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.441ms  | ±1.40%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 222.123ms | ±20.67% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.689ms  | ±1.32%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.633ms  | ±0.43%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.657ms  | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.782ms  | ±1.23%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.185ms  | ±0.85%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.409ms   | ±1.60%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.708ms  | ±0.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.674ms  | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.426ms  | ±0.50%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.269ms   | ±1.29%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.712ms   | ±1.17%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.947ms   | ±0.34%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.039ms   | ±1.24%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.418ms   | ±1.21%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.072ms   | ±0.73%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.428ms   | ±0.84%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.904ms   | ±0.37%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 563.233μs | ±2.65%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.972ms   | ±0.95%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.974ms   | ±0.82%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.884ms   | ±0.56%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 30.030ms  | ±1.26%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.029ms   | ±1.18%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.540ms   | ±0.81%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.403ms   | ±1.10%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.612ms   | ±1.09%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.924ms   | ±0.97%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.588μs   | ±2.67%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.219ms   | ±0.92%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.623mb | 53.185ms  | ±0.81%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 15.211mb | 108.542ms | ±0.30%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.397mb | 1.300s    | ±0.37%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.820mb | 26.271ms  | ±1.67%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.846mb | 59.583ms  | ±0.91%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.591mb | 547.226ms | ±1.82%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.103mb | 64.735ms  | ±9.42%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.757mb | 87.030ms  | ±0.87%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.526mb | 746.890ms | ±0.47%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.868mb | 21.769ms  | ±0.47%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.868mb | 46.344ms  | ±0.88%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.510mb | 329.156ms | ±0.74%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.380μs  | ±1.79%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 245.539μs | ±0.35%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.502ms   | ±1.70%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.309ms  | ±0.95%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.555ms  | ±0.37%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.865ms   | ±0.70%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.183ms  | ±0.47%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.912mb | 78.588ms  | ±0.40%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.302mb | 345.529ms | ±0.35%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 43.922mb | 1.338s    | ±0.58%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.844mb | 240.782ms | ±0.56%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.148mb | 189.690ms | ±0.41%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.698mb | 151.768ms | ±0.44%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.734mb | 202.663ms | ±0.02%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 16.292mb | 167.627ms | ±1.23%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.770mb | 321.457ms | ±0.57%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 14.438mb | 48.573ms  | ±1.54%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 14.357mb | 42.331ms  | ±0.07%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 14.286mb | 40.540ms  | ±0.33%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 15.587mb | 134.408ms | ±0.35%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 14.346mb | 44.621ms  | ±0.34%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 14.558mb | 56.431ms  | ±0.34%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 14.975mb | 83.447ms  | ±0.74%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 14.253mb | 35.316ms  | ±0.38%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 14.501mb | 44.105ms  | ±0.66%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 14.283mb | 45.990ms  | ±1.78%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 14.356mb | 45.164ms  | ±1.30%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 14.274mb | 43.484ms  | ±0.56%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 29.819mb | 120.359ms | ±0.46%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 16.797mb | 42.410ms  | ±0.49%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 15.549mb | 37.861ms  | ±0.39%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.221mb | 40.676ms  | ±0.61%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.289mb | 46.119ms  | ±0.78%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.235mb | 45.525ms  | ±0.56%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 17.964mb | 41.556ms  | ±0.21%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.535mb | 211.740ms | ±1.09%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.817mb | 167.848ms | ±0.76%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.186ms   | ±1.01%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.893ms  | ±0.47%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.734ms  | ±0.78%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.371ms   | ±1.83%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.503ms   | ±0.66%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.364ms   | ±1.44%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.841ms   | ±1.09%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 7.114ms   | ±1.15%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.754ms   | ±1.26%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.291ms   | ±9.17%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.780ms   | ±0.71%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.409ms   | ±0.55%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.600ms   | ±2.42%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.782ms  | ±0.37%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.421ms   | ±1.17%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.657ms   | ±0.73%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.919ms   | ±1.27%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 6.044ms   | ±1.39%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.548ms   | ±0.40%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 18.043ms  | ±1.51%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.449ms  | ±0.81%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.789ms  | ±1.40%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.821ms  | ±1.12%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.793ms  | ±0.86%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.094ms   | ±2.16%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.136ms   | ±0.74%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.227ms   | ±1.51%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.920ms   | ±1.55%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.760ms   | ±0.62%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```