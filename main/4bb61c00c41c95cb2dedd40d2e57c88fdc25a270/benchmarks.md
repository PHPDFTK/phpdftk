# Benchmark Results

> **Auto-generated.** Run `scripts/benchmark` from the repo root to update this file.

Generated: 2026-09-02 04:43:30 UTC
PHP: 8.4.25
Environment: no opcache, no xdebug

---

## Generation Time — `GeneratePdfBench`

| Library | 1 page | 5 pages | 10 pages | 50 pages | 100 pages |
|---|---|---|---|---|---|
| phpdftk | 13.719ms | 2.688ms | 2.822ms | 4.901ms | 7.259ms |
| FPDF | 813.419μs | 877.217μs | 970.464μs | 1.585ms | 2.376ms |
| TCPDF | 10.606ms | 11.623ms | 12.419ms | 21.778ms | 32.654ms |
| mPDF | 27.659ms | 31.792ms | 35.768ms | 69.327ms | 108.777ms |
| Dompdf | 11.890ms | 16.874ms | 22.637ms | 75.706ms | 168.362ms |

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
| phpdftk | 3.543ms | 3.713ms | 4.019ms | 6.138ms | 8.807ms |
| FPDF | 1.111ms | 1.176ms | 1.268ms | 1.978ms | 2.832ms |
| TCPDF | 18.667ms | 20.071ms | 21.149ms | 31.214ms | 44.073ms |

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
| Pdf (Level 3) | 3.501ms | 4.596ms | 13.060ms |
| PdfDoc (Level 2) | 2.828ms | 3.249ms | 7.737ms |
| PdfWriter (Level 1) | 2.404ms | 2.856ms | 7.027ms |

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
| Pdf (Level 3) | 4.476ms | 12.381ms | 47.136ms |
| PdfDoc (Level 2) | 3.806ms | 9.943ms | — |

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
| Pdf (Level 3) | 4.213ms | 11.994ms | 46.118ms |
| PdfDoc (Level 2) | 3.446ms | 7.477ms | — |

### Peak Memory

| Library | 10 items | 100 items | 500 items |
|---|---|---|---|
| Pdf (Level 3) | 6.035mb | 6.587mb | 9.031mb |
| PdfDoc (Level 2) | 5.824mb | 6.318mb | — |

## Parse Time — `ReadPdfBench`

| Library | 1 page | 10 pages | 100 pages |
|---|---|---|---|
| phpdftk | 6.429ms | 1.703ms | 6.264ms |
| smalot/pdfparser | 2.015ms | 2.368ms | 5.763ms |
| setasign/fpdi | 2.006ms | 2.901ms | 30.324ms |

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
| phpdftk | 2.131ms | 1.386ms |
| smalot/pdfparser | FAIL | 2.015ms |
| setasign/fpdi | 3.030ms | FAIL |

---

## Raw phpbench Output

```
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| benchmark                   | subject                                          | set | revs | its | mem_peak | mode      | rstdev  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+
| SvgToPdfBench               | benchBasicShapes                                 |     | 3    | 3   | 8.301mb  | 10.640ms  | ±0.63%  |
| SvgToPdfBench               | benchPathHeavyDocument                           |     | 3    | 3   | 9.195mb  | 10.926ms  | ±1.10%  |
| SvgToPdfBench               | benchGradientHeavyDocument                       |     | 3    | 3   | 9.018mb  | 12.238ms  | ±0.20%  |
| SvgToPdfBench               | benchTextHeavyDocument                           |     | 3    | 3   | 9.043mb  | 12.586ms  | ±2.61%  |
| SvgToPdfBench               | benchUseSymbolExpansion                          |     | 3    | 3   | 9.528mb  | 11.566ms  | ±1.52%  |
| SvgToPdfBench               | benchClipAndMaskHeavy                            |     | 3    | 3   | 8.599mb  | 10.704ms  | ±1.56%  |
| SvgToPdfBench               | benchRealisticIconAtlas                          |     | 3    | 3   | 10.844mb | 20.060ms  | ±1.06%  |
| SvgToPdfBench               | benchTranslatorWithoutAdapter                    |     | 3    | 3   | 5.748mb  | 3.150ms   | ±0.66%  |
| ListsBench                  | benchLevel3PdfList10Items                        |     | 3    | 5   | 6.035mb  | 4.213ms   | ±1.07%  |
| ListsBench                  | benchLevel3PdfList100Items                       |     | 3    | 5   | 6.587mb  | 11.994ms  | ±0.61%  |
| ListsBench                  | benchLevel3PdfList500Items                       |     | 3    | 5   | 9.031mb  | 46.118ms  | ±0.53%  |
| ListsBench                  | benchLevel2PdfDocList10Items                     |     | 3    | 5   | 5.824mb  | 3.446ms   | ±0.55%  |
| ListsBench                  | benchLevel2PdfDocList100Items                    |     | 3    | 5   | 6.318mb  | 7.477ms   | ±0.66%  |
| FontFaceLoadBench           | benchLoadOpenTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.485μs   | ±80.81% |
| FontFaceLoadBench           | benchLoadTrueTypeFromBytes                       |     | 5    | 3   | 4.243mb  | 2.333μs   | ±30.86% |
| FontFaceLoadBench           | benchOpenTypeFontFaceRender                      |     | 5    | 3   | 15.246mb | 16.736ms  | ±2.40%  |
| FontFaceLoadBench           | benchTrueTypeFontFaceRender                      |     | 5    | 3   | 15.246mb | 16.859ms  | ±0.84%  |
| HtmlRendererComparisonBench | benchPhpdftkSmall                                |     | 3    | 3   | 16.048mb | 55.793ms  | ±0.44%  |
| HtmlRendererComparisonBench | benchPhpdftkMedium                               |     | 3    | 3   | 16.639mb | 119.117ms | ±1.00%  |
| HtmlRendererComparisonBench | benchPhpdftkLong                                 |     | 3    | 3   | 42.291mb | 1.390s    | ±1.46%  |
| HtmlRendererComparisonBench | benchDompdfSmall                                 |     | 3    | 3   | 15.211mb | 27.580ms  | ±2.42%  |
| HtmlRendererComparisonBench | benchDompdfMedium                                |     | 3    | 3   | 17.237mb | 58.954ms  | ±2.97%  |
| HtmlRendererComparisonBench | benchDompdfLong                                  |     | 3    | 3   | 57.048mb | 570.941ms | ±0.15%  |
| HtmlRendererComparisonBench | benchMpdfSmall                                   |     | 3    | 3   | 29.495mb | 67.316ms  | ±10.11% |
| HtmlRendererComparisonBench | benchMpdfMedium                                  |     | 3    | 3   | 24.214mb | 88.791ms  | ±1.54%  |
| HtmlRendererComparisonBench | benchMpdfLong                                    |     | 3    | 3   | 32.983mb | 740.573ms | ±0.39%  |
| HtmlRendererComparisonBench | benchTcpdfSmall                                  |     | 3    | 3   | 17.259mb | 20.109ms  | ±1.67%  |
| HtmlRendererComparisonBench | benchTcpdfMedium                                 |     | 3    | 3   | 17.259mb | 43.367ms  | ±1.09%  |
| HtmlRendererComparisonBench | benchTcpdfLong                                   |     | 3    | 3   | 29.902mb | 327.502ms | ±0.08%  |
| TablesBench                 | benchLevel3PdfTable10Rows                        |     | 3    | 5   | 6.403mb  | 4.476ms   | ±1.50%  |
| TablesBench                 | benchLevel3PdfTable100Rows                       |     | 3    | 5   | 9.198mb  | 12.381ms  | ±0.44%  |
| TablesBench                 | benchLevel3PdfTable500Rows                       |     | 3    | 5   | 21.607mb | 47.136ms  | ±0.96%  |
| TablesBench                 | benchLevel2PdfDocTable10Rows                     |     | 3    | 5   | 6.210mb  | 3.806ms   | ±0.87%  |
| TablesBench                 | benchLevel2PdfDocTable100Rows                    |     | 3    | 5   | 9.025mb  | 9.943ms   | ±0.76%  |
| ReadPdfBench                | benchPhpdftk1Page                                |     | 3    | 5   | 4.243mb  | 1.238ms   | ±2.23%  |
| ReadPdfBench                | benchPhpdftk10Pages                              |     | 3    | 5   | 4.243mb  | 1.703ms   | ±0.71%  |
| ReadPdfBench                | benchPhpdftk100Pages                             |     | 3    | 5   | 4.595mb  | 6.264ms   | ±0.53%  |
| ReadPdfBench                | benchPhpdftkSpecCompliantXref                    |     | 3    | 5   | 4.243mb  | 2.131ms   | ±0.99%  |
| ReadPdfBench                | benchPhpdftkXrefStream                           |     | 3    | 5   | 4.243mb  | 1.386ms   | ±0.99%  |
| ReadPdfBench                | benchSmalot1Page                                 |     | 3    | 5   | 4.800mb  | 2.015ms   | ±0.45%  |
| ReadPdfBench                | benchSmalot10Pages                               |     | 3    | 5   | 4.884mb  | 2.368ms   | ±1.22%  |
| ReadPdfBench                | benchSmalot100Pages                              |     | 3    | 5   | 6.601mb  | 5.763ms   | ±8.90%  |
| ReadPdfBench                | benchSmalotSpecCompliantXref                     |     | 3    | 5   | 4.243mb  | 579.885μs | ±2.50%  |
| ReadPdfBench                | benchSmalotXrefStream                            |     | 3    | 5   | 4.794mb  | 2.015ms   | ±2.11%  |
| ReadPdfBench                | benchFpdi1Page                                   |     | 3    | 5   | 4.743mb  | 2.006ms   | ±1.59%  |
| ReadPdfBench                | benchFpdi10Pages                                 |     | 3    | 5   | 4.769mb  | 2.901ms   | ±0.60%  |
| ReadPdfBench                | benchFpdi100Pages                                |     | 3    | 5   | 5.526mb  | 30.324ms  | ±1.18%  |
| ReadPdfBench                | benchFpdiSpecCompliantXref                       |     | 3    | 5   | 4.874mb  | 3.030ms   | ±0.70%  |
| ReadPdfBench                | benchFpdiXrefStream                              |     | 3    | 5   | 4.670mb  | 1.561ms   | ±1.88%  |
| ReadPdfBench                | benchPhpdftkTextExtractionWithFormXObjects       |     | 3    | 5   | 5.956mb  | 7.476ms   | ±0.91%  |
| ReadPdfBench                | benchPhpdftkPositionedTextExtraction             |     | 3    | 5   | 5.928mb  | 5.693ms   | ±1.13%  |
| ReadPdfBench                | benchPhpdftkLinearizedPdf                        |     | 3    | 5   | 5.971mb  | 3.960ms   | ±1.22%  |
| ReadPdfBench                | benchPhpdftkWoff2Parsing                         |     | 5    | 3   | 4.243mb  | 4.068μs   | ±26.57% |
| ReadPdfBench                | benchPhpdftkConformanceChecker                   |     | 3    | 5   | 5.341mb  | 6.429ms   | ±0.56%  |
| BoxGeneratorBench           | benchSmallBlogPost                               |     | 5    | 3   | 8.472mb  | 26.491ms  | ±0.37%  |
| BoxGeneratorBench           | benchMediumArticle                               |     | 5    | 3   | 15.480mb | 237.752ms | ±0.44%  |
| BoxGeneratorBench           | benchLargeDocumentationPage                      |     | 5    | 3   | 47.098mb | 1.175s    | ±0.27%  |
| WriterLevelsBench           | benchLevel1PdfWriter1Page                        |     | 3    | 5   | 5.385mb  | 2.404ms   | ±6.96%  |
| WriterLevelsBench           | benchLevel1PdfWriter10Pages                      |     | 3    | 5   | 5.544mb  | 2.856ms   | ±1.49%  |
| WriterLevelsBench           | benchLevel1PdfWriter100Pages                     |     | 3    | 5   | 7.119mb  | 7.027ms   | ±1.16%  |
| WriterLevelsBench           | benchLevel2PdfDoc1Page                           |     | 3    | 5   | 5.709mb  | 2.828ms   | ±1.28%  |
| WriterLevelsBench           | benchLevel2PdfDoc10Pages                         |     | 3    | 5   | 5.868mb  | 3.249ms   | ±1.28%  |
| WriterLevelsBench           | benchLevel2PdfDoc100Pages                        |     | 3    | 5   | 7.436mb  | 7.737ms   | ±0.73%  |
| WriterLevelsBench           | benchLevel3Pdf1Page                              |     | 3    | 5   | 6.052mb  | 3.501ms   | ±7.74%  |
| WriterLevelsBench           | benchLevel3Pdf10Pages                            |     | 3    | 5   | 6.216mb  | 4.596ms   | ±1.08%  |
| WriterLevelsBench           | benchLevel3Pdf100Pages                           |     | 3    | 5   | 7.892mb  | 13.060ms  | ±1.12%  |
| GeneratePdfBench            | benchPhpdftk1Page                                |     | 3    | 5   | 5.882mb  | 2.360ms   | ±2.56%  |
| GeneratePdfBench            | benchPhpdftk5Pages                               |     | 3    | 5   | 5.943mb  | 2.688ms   | ±11.58% |
| GeneratePdfBench            | benchPhpdftk10Pages                              |     | 3    | 5   | 6.029mb  | 2.822ms   | ±1.02%  |
| GeneratePdfBench            | benchPhpdftk50Pages                              |     | 3    | 5   | 6.663mb  | 4.901ms   | ±1.35%  |
| GeneratePdfBench            | benchPhpdftk100Pages                             |     | 3    | 5   | 7.485mb  | 7.259ms   | ±1.15%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithBookmarksAndTransitions   |     | 3    | 5   | 6.346mb  | 3.720ms   | ±1.49%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithAnnotations               |     | 3    | 5   | 6.338mb  | 3.945ms   | ±1.03%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithEmbeddedFont              |     | 3    | 5   | 8.775mb  | 12.514ms  | ±14.42% |
| GeneratePdfBench            | benchPhpdftk10PagesWithDocumentStructure         |     | 3    | 5   | 6.389mb  | 3.752ms   | ±0.96%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithType3Font                 |     | 3    | 5   | 5.671mb  | 2.490ms   | ±1.44%  |
| GeneratePdfBench            | benchPhpdftkXRefAndObjectStreams                 |     | 3    | 5   | 4.646mb  | 659.866μs | ±2.21%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithShadingsAndPatterns       |     | 3    | 5   | 6.100mb  | 3.179ms   | ±1.81%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithMultimediaAnd3D           |     | 3    | 5   | 6.194mb  | 3.721ms   | ±1.38%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithSignatureField            |     | 3    | 5   | 6.114mb  | 3.323ms   | ±1.32%  |
| GeneratePdfBench            | benchPhpdftk10PagesSigned                        |     | 3    | 5   | 6.170mb  | 166.684ms | ±39.68% |
| GeneratePdfBench            | benchPhpdftk10PagesWithMarkupAnnotations         |     | 3    | 5   | 6.232mb  | 3.682ms   | ±1.50%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithImageStamp                |     | 3    | 5   | 6.847mb  | 6.195ms   | ±16.34% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfStamp                  |     | 3    | 5   | 6.979mb  | 6.293ms   | ±1.02%  |
| GeneratePdfBench            | benchTcpdf1Page                                  |     | 3    | 5   | 12.912mb | 10.606ms  | ±0.94%  |
| GeneratePdfBench            | benchTcpdf5Pages                                 |     | 3    | 5   | 12.912mb | 11.623ms  | ±2.22%  |
| GeneratePdfBench            | benchTcpdf10Pages                                |     | 3    | 5   | 12.912mb | 12.419ms  | ±1.73%  |
| GeneratePdfBench            | benchTcpdf50Pages                                |     | 3    | 5   | 12.912mb | 21.778ms  | ±1.04%  |
| GeneratePdfBench            | benchTcpdf100Pages                               |     | 3    | 5   | 12.912mb | 32.654ms  | ±0.68%  |
| GeneratePdfBench            | benchFpdf1Page                                   |     | 3    | 5   | 5.072mb  | 813.419μs | ±6.18%  |
| GeneratePdfBench            | benchFpdf5Pages                                  |     | 3    | 5   | 5.072mb  | 877.217μs | ±3.16%  |
| GeneratePdfBench            | benchFpdf10Pages                                 |     | 3    | 5   | 5.072mb  | 970.464μs | ±2.04%  |
| GeneratePdfBench            | benchFpdf50Pages                                 |     | 3    | 5   | 5.072mb  | 1.585ms   | ±0.82%  |
| GeneratePdfBench            | benchFpdf100Pages                                |     | 3    | 5   | 5.084mb  | 2.376ms   | ±0.74%  |
| GeneratePdfBench            | benchMpdf1Page                                   |     | 3    | 5   | 17.624mb | 27.659ms  | ±2.31%  |
| GeneratePdfBench            | benchMpdf5Pages                                  |     | 3    | 5   | 17.683mb | 31.792ms  | ±0.64%  |
| GeneratePdfBench            | benchMpdf10Pages                                 |     | 3    | 5   | 17.721mb | 35.768ms  | ±0.44%  |
| GeneratePdfBench            | benchMpdf50Pages                                 |     | 3    | 5   | 18.014mb | 69.327ms  | ±0.56%  |
| GeneratePdfBench            | benchMpdf100Pages                                |     | 3    | 5   | 18.376mb | 108.777ms | ±2.14%  |
| GeneratePdfBench            | benchDompdf1Page                                 |     | 3    | 5   | 9.357mb  | 11.890ms  | ±1.78%  |
| GeneratePdfBench            | benchDompdf5Pages                                |     | 3    | 5   | 9.577mb  | 16.874ms  | ±0.89%  |
| GeneratePdfBench            | benchDompdf10Pages                               |     | 3    | 5   | 9.898mb  | 22.637ms  | ±1.04%  |
| GeneratePdfBench            | benchDompdf50Pages                               |     | 3    | 5   | 12.591mb | 75.706ms  | ±0.75%  |
| GeneratePdfBench            | benchDompdf100Pages                              |     | 3    | 5   | 15.954mb | 168.362ms | ±0.77%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithFormAppearances           |     | 3    | 5   | 7.044mb  | 5.236ms   | ±0.92%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCustomFontFormAppearances |     | 3    | 5   | 8.491mb  | 51.671ms  | ±1.48%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithOpenTypeCff               |     | 3    | 5   | 4.646mb  | 1.667μs   | ±7.69%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithCffSubsetting             |     | 3    | 5   | 4.646mb  | 1.667μs   | ±0.00%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithKernedText                |     | 3    | 5   | 4.646mb  | 1.666μs   | ±8.33%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPublicKeyEncryption       |     | 3    | 5   | 5.059mb  | 258.280ms | ±32.35% |
| GeneratePdfBench            | benchPhpdftkTsaRequestBuildAndParse              |     | 3    | 5   | 4.646mb  | 460.776μs | ±1.23%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithVersionGating             |     | 5    | 3   | 7.458mb  | 3.056ms   | ±2.15%  |
| GeneratePdfBench            | benchPhpdftk10PagesLinearized                    |     | 3    | 5   | 6.056mb  | 3.508ms   | ±0.77%  |
| GeneratePdfBench            | benchPhpdftkType1FontParsing                     |     | 10   | 5   | 4.646mb  | 14.289ms  | ±3.64%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxDecode                       |     | 10   | 5   | 4.646mb  | 85.308ms  | ±0.72%  |
| GeneratePdfBench            | benchPhpdftkCCITTFaxEncode                       |     | 10   | 5   | 4.646mb  | 14.448ms  | ±1.53%  |
| GeneratePdfBench            | benchPhpdftkJbig2Encode                          |     | 10   | 5   | 4.646mb  | 25.131ms  | ±1.07%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithLtvSignature              |     | 3    | 5   | 6.892mb  | 196.898ms | ±15.04% |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfAConformance           |     | 3    | 5   | 9.284mb  | 13.986ms  | ±0.59%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfUaConformance          |     | 3    | 5   | 9.256mb  | 13.971ms  | ±0.88%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfXConformance           |     | 3    | 5   | 9.265mb  | 13.871ms  | ±0.73%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfVtConformance          |     | 3    | 5   | 9.281mb  | 14.189ms  | ±1.86%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfEConformance           |     | 3    | 5   | 9.385mb  | 14.638ms  | ±1.16%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfRConformance           |     | 3    | 5   | 6.053mb  | 3.426ms   | ±1.65%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfX5Conformance          |     | 3    | 5   | 9.268mb  | 14.128ms  | ±1.23%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithZugferdConformance        |     | 3    | 5   | 9.319mb  | 14.060ms  | ±2.17%  |
| GeneratePdfBench            | benchPhpdftk10PagesWithPdfMailConformance        |     | 3    | 5   | 9.213mb  | 13.719ms  | ±0.81%  |
| MemoryBench                 | benchPhpdftk1Page                                |     | 2    | 3   | 5.369mb  | 3.543ms   | ±0.99%  |
| MemoryBench                 | benchPhpdftk5Pages                               |     | 2    | 3   | 5.416mb  | 3.713ms   | ±0.39%  |
| MemoryBench                 | benchPhpdftk10Pages                              |     | 2    | 3   | 5.475mb  | 4.019ms   | ±0.78%  |
| MemoryBench                 | benchPhpdftk50Pages                              |     | 2    | 3   | 5.967mb  | 6.138ms   | ±0.04%  |
| MemoryBench                 | benchPhpdftk100Pages                             |     | 2    | 3   | 6.566mb  | 8.807ms   | ±0.99%  |
| MemoryBench                 | benchTcpdf1Page                                  |     | 2    | 3   | 12.487mb | 18.667ms  | ±0.30%  |
| MemoryBench                 | benchTcpdf5Pages                                 |     | 2    | 3   | 12.487mb | 20.071ms  | ±2.19%  |
| MemoryBench                 | benchTcpdf10Pages                                |     | 2    | 3   | 12.487mb | 21.149ms  | ±0.29%  |
| MemoryBench                 | benchTcpdf50Pages                                |     | 2    | 3   | 12.487mb | 31.214ms  | ±0.10%  |
| MemoryBench                 | benchTcpdf100Pages                               |     | 2    | 3   | 12.488mb | 44.073ms  | ±0.95%  |
| MemoryBench                 | benchFpdf1Page                                   |     | 2    | 3   | 4.455mb  | 1.111ms   | ±1.29%  |
| MemoryBench                 | benchFpdf5Pages                                  |     | 2    | 3   | 4.455mb  | 1.176ms   | ±0.57%  |
| MemoryBench                 | benchFpdf10Pages                                 |     | 2    | 3   | 4.455mb  | 1.268ms   | ±3.73%  |
| MemoryBench                 | benchFpdf50Pages                                 |     | 2    | 3   | 4.455mb  | 1.978ms   | ±0.81%  |
| MemoryBench                 | benchFpdf100Pages                                |     | 2    | 3   | 4.505mb  | 2.832ms   | ±0.28%  |
| EncodingBench               | benchEncodeParagraph                             |     | 50   | 5   | 4.242mb  | 42.324μs  | ±0.85%  |
| EncodingBench               | benchShowTextThroughContentStream                |     | 50   | 5   | 6.501mb  | 251.837μs | ±0.95%  |
| RendererBench               | benchShortDocument                               |     | 3    | 3   | 16.339mb | 87.234ms  | ±0.18%  |
| RendererBench               | benchMediumArticle                               |     | 3    | 3   | 21.169mb | 378.728ms | ±0.93%  |
| RendererBench               | benchLongReport                                  |     | 3    | 3   | 44.832mb | 1.455s    | ±0.25%  |
| RendererBench               | benchRealFaceMatching                            |     | 3    | 3   | 27.400mb | 266.280ms | ±0.95%  |
| RendererBench               | benchPageMarginBoxes                             |     | 3    | 3   | 31.957mb | 205.980ms | ±0.22%  |
| RendererBench               | benchFloats                                      |     | 3    | 3   | 17.123mb | 164.718ms | ±0.41%  |
| RendererBench               | benchMultiColumn                                 |     | 3    | 3   | 18.174mb | 223.261ms | ±0.84%  |
| RendererBench               | benchFlex                                        |     | 3    | 3   | 17.723mb | 186.003ms | ±0.49%  |
| RendererBench               | benchRichTypography                              |     | 3    | 3   | 20.218mb | 349.257ms | ±0.36%  |
| RendererBench               | benchPhase2Grid                                  |     | 3    | 3   | 15.862mb | 55.095ms  | ±1.22%  |
| RendererBench               | benchPhase2GridAdvanced                          |     | 3    | 3   | 15.782mb | 47.073ms  | ±0.56%  |
| RendererBench               | benchPhase2Transform3d                           |     | 3    | 3   | 15.711mb | 44.442ms  | ±0.87%  |
| RendererBench               | benchPhase2TableAutoWidth                        |     | 3    | 3   | 17.012mb | 148.198ms | ±1.00%  |
| RendererBench               | benchPhase2GridAutoTracks                        |     | 3    | 3   | 15.771mb | 49.655ms  | ±0.68%  |
| RendererBench               | benchPhase2GridAutoFlow                          |     | 3    | 3   | 15.982mb | 63.424ms  | ±0.42%  |
| RendererBench               | benchPhase2GridImplicitRows                      |     | 3    | 3   | 16.399mb | 92.562ms  | ±0.51%  |
| RendererBench               | benchPhase2GridTemplateAreas                     |     | 3    | 3   | 15.677mb | 40.498ms  | ±0.65%  |
| RendererBench               | benchPhase2Gradients                             |     | 3    | 3   | 15.615mb | 49.468ms  | ±3.39%  |
| RendererBench               | benchConicGradients                              |     | 3    | 3   | 15.642mb | 50.576ms  | ±0.82%  |
| RendererBench               | benchRadialGradients                             |     | 3    | 3   | 15.611mb | 49.160ms  | ±0.83%  |
| RendererBench               | benchCalcStopGradients                           |     | 3    | 3   | 15.633mb | 47.641ms  | ±0.72%  |
| RendererBench               | benchInterpolatedGradients                       |     | 3    | 3   | 30.597mb | 74.814ms  | ±0.49%  |
| RendererBench               | benchBorderImageRepeat                           |     | 3    | 3   | 17.650mb | 46.370ms  | ±0.41%  |
| RendererBench               | benchTiledGradients                              |     | 3    | 3   | 16.326mb | 41.494ms  | ±1.21%  |
| RendererBench               | benchColorMixResolution                          |     | 3    | 3   | 15.579mb | 44.594ms  | ±0.78%  |
| RendererBench               | benchTranslucentGradients                        |     | 3    | 3   | 15.600mb | 50.637ms  | ±1.05%  |
| RendererBench               | benchGradientMasks                               |     | 3    | 3   | 15.593mb | 49.728ms  | ±0.35%  |
| RendererBench               | benchBackgroundRepeatSpace                       |     | 3    | 3   | 18.817mb | 45.764ms  | ±1.16%  |
| RendererBench               | benchPhase2BorderCollapseHeavy                   |     | 3    | 3   | 18.965mb | 232.282ms | ±0.46%  |
| RendererBench               | benchPhase2MediaQueriesScale                     |     | 3    | 3   | 16.243mb | 175.919ms | ±0.91%  |
| StylingBench                | benchLevel3PdfUnderlined50Items                  |     | 3    | 5   | 6.797mb  | 9.359ms   | ±12.52% |
| StylingBench                | benchLevel3PdfBlockquote50Items                  |     | 3    | 5   | 6.612mb  | 8.799ms   | ±0.69%  |
| StylingBench                | benchLevel3PdfCallout50Items                     |     | 3    | 5   | 6.821mb  | 8.868ms   | ±0.98%  |
+-----------------------------+--------------------------------------------------+-----+------+-----+----------+-----------+---------+

```