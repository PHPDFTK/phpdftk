<?php

declare(strict_types=1);

/**
 * Render a single WPT fixture (HTML / XHTML / SVG) to a PNG, using the
 * EXACT same path as the WPT gate (Phpdftk\WptHarness\HarnessRunner) so
 * local debugging matches scored results.
 *
 * Usage:
 *   php scripts/render-fixture.php <fixture.{html,xht,xhtml,htm,svg}> <out.png> [pageIndex]
 *
 * The DOM settler is intentionally NOT run — this mirrors the deterministic
 * settler-off gate (WPT_DISABLE_DOM_SETTLER=1). Fixtures that depend on JS
 * therefore render their pre-JS source, exactly as the gate scores them.
 *
 * `.xht` / `.xhtml` are handed to the same Renderer as `.html`; the HTML
 * parser accepts the XHTML source verbatim (the harness does no special
 * casing), so column/table/positioning reftests written as `.xht` render
 * identically here and can be instrumented via the real class stack.
 */

use Phpdftk\HtmlToPdf\Renderer;
use Phpdftk\HtmlToPdf\RendererOptions;
use Phpdftk\Pdf\Writer\PdfWriter;
use Phpdftk\Svg\Parser as SvgParser;
use Phpdftk\SvgToPdf\SvgRenderer;
use Phpdftk\WptHarness\Rasteriser;

// Locate the Composer autoloader robustly so the script works whether it
// lives in the repo's scripts/ dir or a /tmp copy: try alongside the
// script, then walk up from the current working directory.
$autoload = null;
foreach ([__DIR__ . '/../vendor/autoload.php', getcwd() . '/vendor/autoload.php'] as $candidate) {
    if (is_file($candidate)) {
        $autoload = $candidate;
        break;
    }
}
if ($autoload === null) {
    $dir = getcwd();
    while ($dir !== '' && $dir !== '/' && $dir !== dirname($dir)) {
        if (is_file($dir . '/vendor/autoload.php')) {
            $autoload = $dir . '/vendor/autoload.php';
            break;
        }
        $dir = dirname($dir);
    }
}
if ($autoload === null) {
    fwrite(STDERR, "could not locate vendor/autoload.php; run from the repo root\n");
    exit(2);
}
require $autoload;

if ($argc < 3) {
    fwrite(STDERR, "usage: render-fixture.php <fixture> <out.png> [pageIndex]\n");
    exit(2);
}

$input = $argv[1];
$output = $argv[2];
$pageIndex = isset($argv[3]) ? max(0, (int) $argv[3]) : 0;

$abs = realpath($input);
if ($abs === false || !is_file($abs)) {
    fwrite(STDERR, "fixture not found: $input\n");
    exit(1);
}

$source = file_get_contents($abs);
if ($source === false) {
    fwrite(STDERR, "could not read fixture: $abs\n");
    exit(1);
}

// Sandbox root = the WPT corpus root so refs in `reference/` subdirs can
// resolve `../support/*` siblings (same policy as HarnessRunner). Fall back
// to the fixture's own directory when the file isn't under vendor-data/wpt.
$sandboxRoot = dirname($abs);
if (preg_match('#^(.*/vendor-data/wpt)(/|$)#', $abs, $m) === 1) {
    $sandboxRoot = $m[1];
}

$ext = strtolower(pathinfo($abs, PATHINFO_EXTENSION));

if ($ext === 'svg') {
    $writer = new PdfWriter();
    $page = $writer->addPage();
    $svgDoc = (new SvgParser())->parse($source);
    (new SvgRenderer($page, $writer))->draw($svgDoc, x: 0, y: 0);
    $pdfBytes = $writer->toBytes();
} else {
    // Mirror HarnessRunner::renderHtmlToPdf option-for-option.
    $renderer = new Renderer(
        (new RendererOptions())
            ->withBaseDir(dirname($abs))
            ->withSandboxRoot($sandboxRoot)
            ->withMatchingMediaTypes(['print', 'screen']),
    );
    $pdfBytes = $renderer->render($source)->writer->toBytes();
}

$pdfPath = tempnam(sys_get_temp_dir(), 'render_fixture_') . '.pdf';
file_put_contents($pdfPath, $pdfBytes);
try {
    $png = (new Rasteriser())->rasterise($pdfPath, $pageIndex);
} finally {
    @unlink($pdfPath);
}

if (!@copy($png, $output)) {
    @unlink($png);
    fwrite(STDERR, "could not write output: $output\n");
    exit(1);
}
@unlink($png);
