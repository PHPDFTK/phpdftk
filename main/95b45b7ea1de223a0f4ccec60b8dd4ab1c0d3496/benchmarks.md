# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-07-31 06:18:44 UTC
PHP: 8.4.24
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.615ms | 2.529ms | 2.786ms | 4.818ms | 7.082ms |
| FPDF | 775.699μs | 844.654μs | 951.332μs | 1.536ms | 2.295ms |
| TCPDF | 10.071ms | 11.096ms | 12.289ms | 21.084ms | 31.487ms |
| mPDF | 25.781ms | 29.751ms | 34.423ms | 66.951ms | 107.691ms |
| Dompdf | 11.721ms | 16.867ms | 22.435ms | 75.386ms | 165.529ms |

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
| phpdftk | 3.312ms | 3.580ms | 3.867ms | 5.899ms | 8.384ms |
| FPDF | 1.044ms | 1.088ms | 1.234ms | 1.904ms | 2.732ms |
| TCPDF | 17.355ms | 18.287ms | 19.530ms | 29.238ms | 41.689ms |

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
| Pdf (Level 3) | 3.407ms | 4.482ms | 12.705ms |
| PdfDoc (Level 2) | 2.714ms | 3.203ms | 7.652ms |
| PdfWriter (Level 1) | 2.352ms | 2.778ms | 6.949ms |

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
| Pdf (Level 3) | 4.435ms | 12.231ms | 47.453ms |
| PdfDoc (Level 2) | 3.831ms | 10.226ms | — |

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
| Pdf (Level 3) | 4.143ms | 11.722ms | 45.484ms |
| PdfDoc (Level 2) | 3.352ms | 7.365ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.192ms | 1.672ms | 5.896ms |
| smalot/pdfparser | 2.032ms | 2.413ms | 5.800ms |
| setasign/fpdi | 1.991ms | 2.867ms | 29.998ms |

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
| phpdftk | 2.032ms | 1.383ms |
| smalot/pdfparser | FAIL | 1.948ms |
| setasign/fpdi | 2.997ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 8.995ms   | ±1.42%  |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.518ms   | ±0.74%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.646ms   | ±6.20%  |
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.215mb  | 10.066ms  | ±0.48%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.087mb  | 10.079ms  | ±0.75%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 8.913mb  | 11.676ms  | ±0.09%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 8.957mb  | 11.874ms  | ±0.05%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.376mb  | 10.931ms  | ±0.23%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.514mb  | 10.201ms  | ±0.45%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.756mb | 19.275ms  | ±0.50%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.731mb  | 3.027ms   | ±0.91%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.279mb  | 23.966ms  | ±0.26%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.264mb | 213.560ms | ±0.96%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 46.780mb | 1.065s    | ±0.27%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.849μs   | ±18.25% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 1.873μs   | ±25.71% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 13.890mb | 15.031ms  | ±0.19%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 13.890mb | 15.031ms  | ±0.01%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.310ms   | ±0.51%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.529ms   | ±0.66%  |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.786ms   | ±0.68%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.818ms   | ±0.92%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.082ms   | ±0.31%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.611ms   | ±15.55% |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.852ms   | ±0.32%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.368ms  | ±1.66%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.678ms   | ±0.79%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.387ms   | ±0.21%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 638.037μs | ±2.70%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.251ms   | ±0.76%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.725ms   | ±1.63%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.260ms   | ±0.55%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 182.210ms | ±24.40% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.660ms   | ±8.06%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 5.873ms   | ±28.89% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.109ms   | ±5.21%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.071ms  | ±0.98%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.096ms  | ±0.63%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.289ms  | ±0.71%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 21.084ms  | ±0.54%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 31.487ms  | ±0.99%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 775.699μs | ±1.70%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 844.654μs | ±1.86%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 951.332μs | ±17.34% |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.536ms   | ±1.62%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.295ms   | ±0.43%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 25.781ms  | ±1.85%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 29.751ms  | ±1.25%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 34.423ms  | ±1.17%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 66.951ms  | ±0.95%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 107.691ms | ±0.68%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.721ms  | ±1.90%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.867ms  | ±0.64%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 22.435ms  | ±0.68%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 75.386ms  | ±0.51%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 165.529ms | ±1.02%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.184ms   | ±0.70%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 50.229ms  | ±0.75%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.656μs   | ±10.65% |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 300.565ms | ±23.83% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 471.644μs | ±0.68%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.026ms   | ±0.71%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.453ms   | ±2.12%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 12.598ms  | ±6.75%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 87.190ms  | ±0.98%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 15.067ms  | ±2.06%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.074ms  | ±8.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 155.468ms | ±23.53% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.887ms  | ±1.10%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.562ms  | ±0.62%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.682ms  | ±1.17%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 13.831ms  | ±0.57%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.047ms  | ±0.51%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.293ms   | ±1.90%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 13.751ms  | ±0.64%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 13.724ms  | ±0.70%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.615ms  | ±0.78%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.261ms   | ±1.23%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.672ms   | ±1.69%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 5.896ms   | ±1.02%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.032ms   | ±0.70%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.383ms   | ±0.73%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.032ms   | ±7.85%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.413ms   | ±0.73%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.800ms   | ±0.92%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 552.525μs | ±1.58%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 1.948ms   | ±0.32%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 1.991ms   | ±1.24%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.867ms   | ±15.93% |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 29.998ms  | ±1.29%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 2.997ms   | ±0.58%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.533ms   | ±0.88%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.307ms   | ±0.40%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.482ms   | ±0.25%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.918ms   | ±3.62%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 3.576μs   | ±5.44%  |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.192ms   | ±0.32%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 14.626mb | 52.373ms  | ±0.45%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 15.214mb | 106.935ms | ±0.15%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 41.400mb | 1.287s    | ±1.05%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 14.823mb | 27.507ms  | ±2.05%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 16.849mb | 61.279ms  | ±0.11%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 56.595mb | 545.974ms | ±0.67%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.106mb | 65.216ms  | ±8.56%  |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 23.760mb | 86.794ms  | ±0.98%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.529mb | 736.672ms | ±0.20%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 16.871mb | 21.626ms  | ±1.07%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 16.871mb | 46.366ms  | ±0.63%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.513mb | 328.655ms | ±0.44%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 41.407μs  | ±0.95%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 243.180μs | ±2.71%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.435ms   | ±1.50%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.231ms  | ±4.33%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.453ms  | ±4.98%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.831ms   | ±0.34%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 10.226ms  | ±5.87%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 14.915mb | 78.394ms  | ±0.83%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 20.371mb | 344.126ms | ±0.89%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 43.990mb | 1.326s    | ±0.68%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 26.847mb | 239.737ms | ±0.45%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.152mb | 191.484ms | ±0.92%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 15.701mb | 150.311ms | ±0.80%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 16.738mb | 201.397ms | ±0.60%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 16.295mb | 164.520ms | ±0.57%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 18.773mb | 313.435ms | ±0.21%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 14.441mb | 48.192ms  | ±0.42%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 14.361mb | 42.047ms  | ±0.97%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 14.290mb | 39.712ms  | ±0.47%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 15.591mb | 131.964ms | ±0.19%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 14.350mb | 44.433ms  | ±1.65%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 14.561mb | 56.169ms  | ±1.00%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 14.978mb | 82.911ms  | ±0.45%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 14.256mb | 35.919ms  | ±0.59%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 14.504mb | 44.357ms  | ±0.79%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 14.287mb | 46.103ms  | ±0.49%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 14.360mb | 44.466ms  | ±0.51%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 14.277mb | 43.379ms  | ±0.73%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 29.823mb | 120.237ms | ±0.35%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 16.800mb | 42.718ms  | ±1.36%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 15.552mb | 37.253ms  | ±0.37%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 14.224mb | 40.674ms  | ±1.44%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 14.293mb | 45.936ms  | ±0.64%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 14.238mb | 44.869ms  | ±1.08%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 17.967mb | 42.819ms  | ±5.38%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 17.538mb | 210.173ms | ±0.28%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 14.820mb | 167.708ms | ±1.01%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.143ms   | ±4.62%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.722ms  | ±0.48%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 45.484ms  | ±0.72%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.352ms   | ±1.86%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.365ms   | ±0.45%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.352ms   | ±0.76%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.778ms   | ±0.33%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 6.949ms   | ±0.58%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.714ms   | ±1.96%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.203ms   | ±0.83%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.652ms   | ±0.49%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.407ms   | ±0.29%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.482ms   | ±1.90%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 12.705ms  | ±0.59%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.312ms   | ±0.26%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.580ms   | ±0.58%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 3.867ms   | ±4.53%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 5.899ms   | ±0.66%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.384ms   | ±0.44%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 17.355ms  | ±0.74%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 18.287ms  | ±0.57%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 19.530ms  | ±0.15%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 29.238ms  | ±0.01%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 41.689ms  | ±0.89%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.044ms   | ±2.14%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.088ms   | ±2.17%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.234ms   | ±1.60%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.904ms   | ±1.20%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.732ms   | ±0.17%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```