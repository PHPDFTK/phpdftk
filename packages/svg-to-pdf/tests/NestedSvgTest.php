<?php

declare(strict_types=1);

namespace Phpdftk\SvgToPdf\Tests;

use Phpdftk\Pdf\Writer\PdfWriter;
use Phpdftk\Svg\Parser as SvgParser;
use Phpdftk\SvgToPdf\SvgRenderer;
use PHPUnit\Framework\TestCase;

/**
 * SVG 2 §7.5 — a nested `<svg>` establishes a new viewport and, with a
 * `viewBox`, a scaled user coordinate system for its children (and clips
 * overflow to the viewport). A `<use>`'s width/height overrides the
 * referenced svg's viewport (§5.6.1).
 */
final class NestedSvgTest extends TestCase
{
    private function render(string $svg): string
    {
        $writer = new PdfWriter();
        $page = $writer->addPage();
        (new SvgRenderer($page, $writer))->draw(
            (new SvgParser())->parse($svg),
            x: 0.0,
            y: 0.0,
            width: 200.0,
            height: 200.0,
        );
        return implode("\n", $page->contentStream()->getOperators());
    }

    public function testNestedSvgViewBoxScalesChildren(): void
    {
        // Inner viewBox 0 0 100 100 into a 10×10 viewport → 0.1 scale.
        $ops = $this->render(
            '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200">'
            . '<svg x="0" y="0" width="10" height="10" viewBox="0 0 100 100">'
            . '<rect width="100" height="100" fill="green"/></svg></svg>',
        );
        // The viewBox-to-viewport scale (0.1) is concatenated, and the
        // viewport is clipped (W … n).
        self::assertStringContainsString('0.1 0 0 0.1', $ops, 'nested viewBox scale applied');
        self::assertStringContainsString('W', $ops, 'nested viewport clip emitted');
    }

    public function testUseWidthHeightOverridesNestedSvgViewport(): void
    {
        // The nested svg has no width/height; the <use> supplies 20×20,
        // so viewBox 0 0 100 100 scales by 0.2.
        $ops = $this->render(
            '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" '
            . 'width="200" height="200">'
            . '<defs><svg id="n" viewBox="0 0 100 100"><rect width="100" height="100" fill="blue"/></svg></defs>'
            . '<use xlink:href="#n" width="20" height="20"/></svg>',
        );
        self::assertStringContainsString('0.2 0 0 0.2', $ops, 'use width/height drives nested viewport scale');
    }
}
