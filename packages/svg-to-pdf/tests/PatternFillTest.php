<?php

declare(strict_types=1);

namespace Phpdftk\SvgToPdf\Tests;

use Phpdftk\Pdf\Core\Content\ContentStream;
use Phpdftk\Svg\Parser as SvgParser;
use Phpdftk\SvgToPdf\Translator;
use PHPUnit\Framework\TestCase;

/**
 * SVG 2 §13.3 — `fill="url(#id)"` resolving to a `<pattern>` paints the
 * pattern tile clipped to the shape. Tiles are emitted as ordinary
 * clipped geometry inside the element's own `q`/`Q` transform wrap (not
 * a PDF tiling pattern), so the element transform in the CTM applies to
 * the tiles automatically.
 */
final class PatternFillTest extends TestCase
{
    private SvgParser $svgParser;
    private Translator $translator;

    protected function setUp(): void
    {
        $this->svgParser = new SvgParser();
        $this->translator = new Translator();
    }

    private function paint(string $svg): string
    {
        $doc = $this->svgParser->parse($svg);
        $stream = new ContentStream();
        $this->translator->paint($doc, $stream);
        return implode("\n", $stream->getOperators());
    }

    public function testPatternFillClipsShapeAndPaintsTileChildren(): void
    {
        $ops = $this->paint(
            '<svg xmlns="http://www.w3.org/2000/svg">'
            . '<defs>'
            . '<pattern id="p" patternUnits="userSpaceOnUse" x="0" y="0" width="100" height="100">'
            . '<rect x="0" y="0" width="50" height="100" fill="green"/>'
            . '<rect x="50" y="0" width="50" height="100" fill="blue"/>'
            . '</pattern>'
            . '</defs>'
            . '<rect width="100" height="100" fill="url(#p)"/>'
            . '</svg>',
        );
        $lines = explode("\n", $ops);
        // The shape path becomes a clip (W n) rather than a flat fill.
        self::assertContains('W', $lines);
        self::assertContains('n', $lines);
        // The tile children paint their own geometry inside the clip.
        self::assertStringContainsString('0 0 50 100 re', $ops);
        self::assertStringContainsString('50 0 50 100 re', $ops);
        // Two coloured child fills landed.
        self::assertSame(2, count(array_filter($lines, static fn(string $l): bool => $l === 'f')));
    }

    public function testPatternFillPaintsInsideElementTransform(): void
    {
        // The referencing rect carries its own transform; the pattern
        // tiles must be painted inside its q/Q wrap (after the cm) so
        // they inherit the scale — this is the svg-matrix-* case.
        $ops = $this->paint(
            '<svg xmlns="http://www.w3.org/2000/svg">'
            . '<defs>'
            . '<pattern id="p" patternUnits="userSpaceOnUse" width="100" height="100">'
            . '<rect width="100" height="100" fill="green"/>'
            . '</pattern>'
            . '</defs>'
            . '<rect width="100" height="100" fill="url(#p)" transform="matrix(0.5 0 0 1 0 0)"/>'
            . '</svg>',
        );
        $lines = explode("\n", $ops);
        // Exactly one outer q/Q pair for the element transform wrap.
        $matrixIndex = array_search('0.5 0 0 1 0 0 cm', $lines, true);
        self::assertNotFalse($matrixIndex, 'element transform cm emitted');
        // Tile geometry appears after the transform cm — i.e. inside the wrap.
        $tileIndex = array_search('0 0 100 100 re', array_slice($lines, (int) $matrixIndex), true);
        self::assertNotFalse($tileIndex, 'tile painted after (inside) the element transform');
    }

    public function testObjectBoundingBoxPatternUnitsScalesTileToBbox(): void
    {
        // Default patternUnits=objectBoundingBox: width/height are
        // fractions of the referencing element's bbox. width=1 height=1
        // ⇒ one tile spans the whole 80×80 rect.
        $ops = $this->paint(
            '<svg xmlns="http://www.w3.org/2000/svg">'
            . '<defs>'
            . '<pattern id="p" width="1" height="1">'
            . '<rect width="40" height="40" fill="green"/>'
            . '</pattern>'
            . '</defs>'
            . '<rect width="80" height="80" fill="url(#p)"/>'
            . '</svg>',
        );
        $lines = explode("\n", $ops);
        // The tile clip rect spans the full bbox (0 0 80 80).
        self::assertStringContainsString('0 0 80 80 re', $ops);
        // The child still paints at its authored coords.
        self::assertStringContainsString('0 0 40 40 re', $ops);
        self::assertContains('W', $lines);
    }

    public function testPatternFillTilesRepeatToCoverShape(): void
    {
        // A 50×50 tile over a 100×100 shape ⇒ 4 cells; each translates
        // onto the grid, so the second column sits at x-offset 50.
        $ops = $this->paint(
            '<svg xmlns="http://www.w3.org/2000/svg">'
            . '<defs>'
            . '<pattern id="p" patternUnits="userSpaceOnUse" width="50" height="50">'
            . '<rect width="50" height="50" fill="green"/>'
            . '</pattern>'
            . '</defs>'
            . '<rect width="100" height="100" fill="url(#p)"/>'
            . '</svg>',
        );
        $lines = explode("\n", $ops);
        // 4 tile cells ⇒ 4 child fills.
        self::assertSame(4, count(array_filter($lines, static fn(string $l): bool => $l === 'f')));
        // Column/row translation onto the tile grid.
        self::assertStringContainsString('1 0 0 1 50 0 cm', $ops);
        self::assertStringContainsString('1 0 0 1 0 50 cm', $ops);
    }

    public function testMissingPatternReferenceFallsBackToNoFill(): void
    {
        // url(#nope) resolves to nothing: no pattern paint, no crash, and
        // no stray flat fill of the shape.
        $ops = $this->paint(
            '<svg xmlns="http://www.w3.org/2000/svg">'
            . '<rect width="10" height="10" fill="url(#nope)"/>'
            . '</svg>',
        );
        $lines = explode("\n", $ops);
        self::assertSame(0, count(array_filter($lines, static fn(string $l): bool => $l === 'f')));
    }

    public function testPatternFilledShapeStillStrokes(): void
    {
        // fill=pattern + a real stroke: the clip consumes the fill path,
        // so the stroke re-emits the path and strokes it (S).
        $ops = $this->paint(
            '<svg xmlns="http://www.w3.org/2000/svg">'
            . '<defs>'
            . '<pattern id="p" patternUnits="userSpaceOnUse" width="20" height="20">'
            . '<rect width="20" height="20" fill="green"/>'
            . '</pattern>'
            . '</defs>'
            . '<rect width="20" height="20" fill="url(#p)" stroke="black" stroke-width="2"/>'
            . '</svg>',
        );
        $lines = explode("\n", $ops);
        self::assertContains('S', $lines);
        // The stroked shape geometry is re-emitted after the pattern fill.
        self::assertStringContainsString('0 0 20 20 re', $ops);
    }
}
