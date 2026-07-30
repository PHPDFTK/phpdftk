<?php

declare(strict_types=1);

/**
 * WPT compliance gallery generator (v0 — self-contained static page).
 *
 * For each test id, renders our output (test HTML → PDF → PNG through the
 * real harness pipeline) and, when the test is a reftest, its WPT
 * reference the same way, then writes an index.html placing them
 * side-by-side so anyone can compare "test → ours → reference".
 *
 * This is Phase 1-2 of docs/plans/wpt-gallery.md, kept deliberately
 * simple (a standalone HTML file, no Astro yet) so there is a page to
 * open TODAY. Scaling to the full corpus + Starlight embedding + the
 * cross-browser oracle columns is the later phases.
 *
 * Usage:
 *   php scripts/build-wpt-gallery.php \
 *       [--root=vendor-data/wpt] [--out=docs/generated/wpt-gallery] \
 *       [id ...]                          # explicit test ids, else a default set
 *
 * Needs Ghostscript (via Rasteriser). Open the emitted index.html in a
 * browser, or `cd <out> && python3 -m http.server`.
 */

use Phpdftk\Filesystem\LocalFilesystem;
use Phpdftk\HtmlToPdf\Renderer;
use Phpdftk\HtmlToPdf\RendererOptions;
use Phpdftk\WptHarness\Rasteriser;

require __DIR__ . '/../vendor/autoload.php';

$root = 'vendor-data/wpt';
$out = 'docs/generated/wpt-gallery';
$ids = [];
foreach (array_slice($argv, 1) as $arg) {
    if (str_starts_with($arg, '--root=')) {
        $root = substr($arg, 7);
    } elseif (str_starts_with($arg, '--out=')) {
        $out = substr($arg, 6);
    } elseif (!str_starts_with($arg, '--')) {
        $ids[] = $arg;
    }
}

// A default curated set: tests fixed in the current CSS push (wins) plus a
// couple still-failing near-misses (gaps), so the gallery shows both.
if ($ids === []) {
    $ids = [
        'css/css-grid/grid-items/grid-order-property-painting-001',
        'css/css-backgrounds/background-color-body-propagation-007',
        'css/css-sizing/aspect-ratio/grid-aspect-ratio-010',
        'css/css-sizing/aspect-ratio/block-aspect-ratio-015',
        'css/css-backgrounds/border-left-width-thick',
        'css/css-backgrounds/box-shadow-005',
        'css/css-flexbox/percentage-heights-006',
        'css/css-writing-modes/abs-pos-non-replaced-vrl-002',
    ];
}

$rasteriser = new Rasteriser();
if (!$rasteriser->isAvailable()) {
    fwrite(STDERR, "build-wpt-gallery: Ghostscript (`gs`) unavailable.\n");
    exit(1);
}

$imgDir = $out . '/img';
@mkdir($imgDir, 0o777, true);
$wptRoot = realpath($root) ?: $root;

/** Resolve a test id to an on-disk file, trying the WPT extensions. */
function resolveFixture(string $root, string $id): ?string
{
    foreach (['', '.html', '.htm', '.xht'] as $ext) {
        $p = $root . '/' . $id . $ext;
        if (is_file($p)) {
            return $p;
        }
    }
    return null;
}

/** The `<link rel="match">` reference of a reftest, resolved to a path. */
function matchReference(string $testPath, string $html): ?string
{
    if (!preg_match('/<link\b[^>]*\brel\s*=\s*["\']match["\'][^>]*>/i', $html, $tag)
        && !preg_match('/<link\b[^>]*\bhref[^>]*\brel\s*=\s*["\']match["\'][^>]*>/i', $html, $tag)) {
        return null;
    }
    if (!preg_match('/\bhref\s*=\s*["\']([^"\']+)["\']/i', $tag[0], $href)) {
        return null;
    }
    $ref = $href[1];
    // Resolve relative to the test's directory.
    $base = dirname($testPath);
    $path = str_starts_with($ref, '/') ? $ref : $base . '/' . $ref;
    $real = realpath($path);
    return $real !== false ? $real : null;
}

/** Render an HTML file to a PNG at $destPng through the harness pipeline. */
function renderTo(string $htmlPath, string $wptRoot, Rasteriser $ras, string $destPng): bool
{
    try {
        $html = LocalFilesystem::readFile($htmlPath, 'gallery fixture');
        $renderer = new Renderer(
            (new RendererOptions())
                ->withBaseDir(dirname($htmlPath))
                ->withSandboxRoot($wptRoot)
                ->withMatchingMediaTypes(['print', 'screen']),
        );
        $pdf = $renderer->render($html)->writer->toBytes();
        $pdfPath = tempnam(sys_get_temp_dir(), 'gal_') . '.pdf';
        LocalFilesystem::writeFile($pdfPath, $pdf);
        $png = $ras->rasterise($pdfPath, 0);
        @unlink($pdfPath);
        copy($png, $destPng);
        @unlink($png);
        return true;
    } catch (\Throwable $e) {
        fwrite(STDERR, "  render failed: {$htmlPath}: {$e->getMessage()}\n");
        return false;
    }
}

$cards = [];
foreach ($ids as $id) {
    $testPath = resolveFixture($wptRoot, $id);
    if ($testPath === null) {
        fwrite(STDERR, "skip (not found): {$id}\n");
        continue;
    }
    $slug = str_replace(['/', '\\'], '__', $id);
    $html = LocalFilesystem::readFile($testPath, 'gallery fixture');
    $assert = preg_match('/name\s*=\s*["\']assert["\']\s+content\s*=\s*["\']([^"\']+)/i', $html, $m)
        ? trim($m[1]) : '';

    $oursPng = "img/{$slug}.ours.png";
    $okOurs = renderTo($testPath, $wptRoot, $rasteriser, $out . '/' . $oursPng);

    $refPng = null;
    $refPath = matchReference($testPath, $html);
    if ($refPath !== null) {
        $refPng = "img/{$slug}.ref.png";
        if (!renderTo($refPath, $wptRoot, $rasteriser, $out . '/' . $refPng)) {
            $refPng = null;
        }
    }

    $cards[] = [
        'id' => $id,
        'assert' => $assert,
        'ours' => $okOurs ? $oursPng : null,
        'ref' => $refPng,
    ];
    fwrite(STDERR, "rendered {$id}" . ($refPng ? ' (+ref)' : '') . "\n");
}

// ---- emit a self-contained index.html ----
$rows = '';
foreach ($cards as $c) {
    $id = htmlspecialchars($c['id']);
    $assert = htmlspecialchars($c['assert']);
    $ours = $c['ours'] !== null
        ? '<img loading="lazy" src="' . htmlspecialchars($c['ours']) . '" alt="ours">'
        : '<div class="missing">render failed</div>';
    $ref = $c['ref'] !== null
        ? '<img loading="lazy" src="' . htmlspecialchars($c['ref']) . '" alt="reference">'
        : '<div class="missing">no reference</div>';
    $rows .= <<<HTML
    <div class="card">
      <div class="hd"><code>{$id}</code></div>
      <div class="assert">{$assert}</div>
      <div class="pair">
        <figure><figcaption>ours</figcaption>{$ours}</figure>
        <figure><figcaption>reference</figcaption>{$ref}</figure>
      </div>
    </div>

    HTML;
}

$count = count($cards);
$page = <<<HTML
<!DOCTYPE html>
<meta charset="utf-8">
<title>phpdftk — WPT compliance gallery</title>
<style>
  body { font: 14px/1.5 -apple-system, system-ui, sans-serif; margin: 0; background: #0f1115; color: #e6e6e6; }
  header { padding: 20px 24px; border-bottom: 1px solid #2a2e37; }
  header h1 { margin: 0 0 4px; font-size: 18px; }
  header p { margin: 0; color: #9aa0aa; }
  .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(420px, 1fr)); gap: 16px; padding: 24px; }
  .card { background: #171a21; border: 1px solid #2a2e37; border-radius: 8px; overflow: hidden; }
  .hd { padding: 10px 12px; border-bottom: 1px solid #2a2e37; font-size: 12px; word-break: break-all; }
  .assert { padding: 8px 12px; color: #9aa0aa; font-size: 12px; min-height: 2.2em; }
  .pair { display: grid; grid-template-columns: 1fr 1fr; gap: 1px; background: #2a2e37; }
  figure { margin: 0; background: #fff; padding: 8px; text-align: center; }
  figure img { max-width: 100%; height: auto; image-rendering: pixelated; }
  figcaption { font-size: 11px; color: #666; margin-bottom: 4px; text-transform: uppercase; letter-spacing: .05em; }
  .missing { color: #b04; padding: 40px 8px; background: #fff; }
</style>
<header>
  <h1>phpdftk — WPT compliance gallery</h1>
  <p>{$count} tests · our render vs the WPT reference, side by side. Generated by scripts/build-wpt-gallery.php — see docs/plans/wpt-gallery.md.</p>
</header>
<div class="grid">
{$rows}</div>
HTML;

LocalFilesystem::writeFile($out . '/index.html', $page);
fwrite(STDERR, "\nwrote {$out}/index.html ({$count} tests)\n");
