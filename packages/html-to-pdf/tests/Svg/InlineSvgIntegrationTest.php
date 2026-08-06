<?php

declare(strict_types=1);

namespace Phpdftk\HtmlToPdf\Tests\Svg;

use Phpdftk\HtmlToPdf\Renderer;
use Phpdftk\Pdf\Writer\PdfWriter;
use PHPUnit\Framework\TestCase;

/**
 * End-to-end coverage for inline `<svg>` rendering inside an HTML
 * document. Drives the full Renderer pipeline (HTML parse → cascade
 * → box tree → layout → paint) with HTML that contains inline SVG,
 * then asserts the resulting PDF actually carries the SVG shapes —
 * before the InlineSvgAdapter / Painter routing landed, the SVG
 * subtree was silently dropped (text leaked through, shapes never
 * painted).
 *
 * Tests use `compressStreams: false` so the assertions can grep the
 * content stream for PDF operators directly.
 */
final class InlineSvgIntegrationTest extends TestCase
{
    public function testInlineSvgRectProducesFilledRectanglePath(): void
    {
        $writer = new PdfWriter(compressStreams: false);
        (new Renderer())->renderInto(
            $writer,
            <<<HTML
            <html><body>
              <p>before</p>
              <svg width="80" height="60" xmlns="http://www.w3.org/2000/svg">
                <rect x="0" y="0" width="80" height="60" fill="#ff0000"/>
              </svg>
              <p>after</p>
            </body></html>
            HTML,
        );
        $bytes = $writer->toBytes();

        self::assertStringStartsWith('%PDF-', $bytes);
        // Red fill colour: `1 0 0 rg` (rgb 255,0,0 normalised to 0..1).
        self::assertMatchesRegularExpression(
            '/\b1(?:\.0+)?\s+0(?:\.0+)?\s+0(?:\.0+)?\s+rg\b/',
            $bytes,
            'red fill colour from inline-SVG rect not emitted',
        );
        // The rect's fill operator `f` (or `B`) must appear after the
        // path is constructed. We assert presence of the fill verb
        // alone; the exact path-construction sequence is the SVG
        // renderer's call.
        self::assertMatchesRegularExpression('/\nf\b/', $bytes, 'no fill operator from inline-SVG rect');
    }

    public function testInlineSvgWithoutDimensionsSkipsCleanly(): void
    {
        // No width/height on the SVG and no CSS → box geometry is zero.
        // The painter must skip (returning early) rather than crash;
        // a valid PDF still emerges. We don't assert text content
        // makes it through (text is encoded via hex Tj strings, not
        // raw ASCII), only that the renderer produced a well-formed
        // PDF with a real content stream.
        $writer = new PdfWriter(compressStreams: false);
        (new Renderer())->renderInto(
            $writer,
            '<html><body>'
                . '<p>before</p>'
                . '<svg xmlns="http://www.w3.org/2000/svg"><rect width="10" height="10" fill="#000"/></svg>'
                . '<p>after</p>'
                . '</body></html>',
        );
        $bytes = $writer->toBytes();
        self::assertStringStartsWith('%PDF-', $bytes);
        self::assertStringEndsWith("%%EOF", trim($bytes));
    }

    public function testInlineSvgClipsOversizedContentToViewport(): void
    {
        // SVG 2 §8.2 / CSS Overflow 3 — the SVG viewport clips content
        // larger than its box (UA default `svg { overflow: clip }`). A
        // 150x150 rect inside a CSS-sized 100x100 svg emits an EXTRA clip
        // (`W n`) around the draw versus the same svg with `overflow:
        // visible`, which paints the rect unconfined. Comparing the two
        // isolates the SVG viewport clip from the always-present page clip.
        $clips = fn(string $extraSvgStyle): int => substr_count(
            (function () use ($extraSvgStyle): string {
                $writer = new PdfWriter(compressStreams: false);
                (new Renderer())->renderInto(
                    $writer,
                    '<html><body>'
                        . '<svg style="width:100px;height:100px;' . $extraSvgStyle . '" xmlns="http://www.w3.org/2000/svg">'
                        . '<rect width="150" height="150" fill="#008000"/>'
                        . '</svg>'
                        . '</body></html>',
                );
                return $writer->toBytes();
            })(),
            "W\nn",
        );

        $default = $clips('');
        $visible = $clips('overflow:visible;');
        self::assertGreaterThan($visible, $default, 'default SVG overflow must add a viewport clip the overflow:visible case omits');
    }

    public function testMalformedInlineSvgSkipsRatherThanCrashes(): void
    {
        // An `<svg>` element with a child whose markup the SVG parser
        // can't make sense of. The render must produce a valid PDF —
        // the malformed inline SVG just doesn't contribute anything.
        $writer = new PdfWriter(compressStreams: false);
        (new Renderer())->renderInto(
            $writer,
            '<html><body>'
                . '<svg width="40" height="40" xmlns="http://www.w3.org/2000/svg">'
                . '<rect width="40" height="40" fill="#fff" stroke=""/>'
                . '</svg>'
                . '</body></html>',
        );
        $bytes = $writer->toBytes();
        self::assertStringStartsWith('%PDF-', $bytes);
        self::assertStringEndsWith("%%EOF", trim($bytes));
    }

    public function testMultipleInlineSvgsRenderIndependently(): void
    {
        // Two distinct <svg> elements in one document. Each must paint
        // its own content (different fills here so we can verify both
        // ended up in the stream). Confirms the adapter cache keys on
        // element identity and doesn't conflate the two.
        $writer = new PdfWriter(compressStreams: false);
        (new Renderer())->renderInto(
            $writer,
            <<<HTML
            <html><body>
              <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg">
                <rect width="30" height="30" fill="#ff0000"/>
              </svg>
              <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg">
                <rect width="30" height="30" fill="#0000ff"/>
              </svg>
            </body></html>
            HTML,
        );
        $bytes = $writer->toBytes();
        self::assertStringStartsWith('%PDF-', $bytes);
        self::assertMatchesRegularExpression(
            '/\b1(?:\.0+)?\s+0(?:\.0+)?\s+0(?:\.0+)?\s+rg\b/',
            $bytes,
            'red fill from first inline SVG missing',
        );
        self::assertMatchesRegularExpression(
            '/\b0(?:\.0+)?\s+0(?:\.0+)?\s+1(?:\.0+)?\s+rg\b/',
            $bytes,
            'blue fill from second inline SVG missing',
        );
    }
}
