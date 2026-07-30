<?php

declare(strict_types=1);

/**
 * Cross-browser oracle PER-ENGINE MATRIX reporter.
 *
 * Where aggregate.php folds shards into a consensus pass/fail summary,
 * this emits the "whole sheet of what passes in what rendering engine":
 * one row per test, one column per engine, each cell answering "does OUR
 * PDF match this engine's print render within its fuzz budget?" — plus a
 * consensus column and per-engine totals so browser-vs-browser gaps are
 * visible, not just the consensus verdict.
 *
 * Input is one or more `wpt cross-browser --json=<path>` dumps (schema in
 * packages/wpt-harness/bin/wpt / scripts/cross-browser/aggregate.php).
 * Multiple dumps (e.g. shards) merge by testId.
 *
 *   php scripts/cross-browser/matrix.php dump1.json [dump2.json ...] \
 *       [--csv=matrix.csv] [--fails-only]
 *
 * Markdown goes to stdout; `--csv` additionally writes a spreadsheet.
 *
 * A cell is:
 *   ✓ 0.00%   our render matches that engine within budget (AE ≤ budget)
 *   ✗ 5.56%   our render diverges (AE > budget) — the % is the pixel AE
 *   –         engine unavailable / not compared for this test
 *   err       harness error rendering this test
 */

use Phpdftk\Filesystem\LocalFilesystem;

$autoloads = [
    __DIR__ . '/../../vendor/autoload.php',
    __DIR__ . '/../../../../autoload.php',
];
foreach ($autoloads as $a) {
    if (is_file($a)) {
        require $a;
        break;
    }
}

const ENGINES = ['chromium', 'firefox', 'webkit'];

$jsonPaths = [];
$csvOut = null;
$failsOnly = false;
foreach (array_slice($argv, 1) as $arg) {
    if (str_starts_with($arg, '--csv=')) {
        $csvOut = substr($arg, strlen('--csv='));
    } elseif ($arg === '--fails-only') {
        $failsOnly = true;
    } elseif (str_starts_with($arg, '--')) {
        fwrite(STDERR, "unknown option: $arg\n");
        exit(2);
    } else {
        $jsonPaths[] = $arg;
    }
}
if ($jsonPaths === []) {
    fwrite(STDERR, "usage: matrix.php <dump.json> [more.json ...] [--csv=out.csv] [--fails-only]\n");
    exit(2);
}

// Merge results across dumps, keyed by testId (later dumps win on
// collision — shards never overlap so this only matters for re-runs).
$rows = [];
foreach ($jsonPaths as $path) {
    $raw = LocalFilesystem::readFile($path, 'cross-browser JSON dump');
    $data = json_decode($raw, associative: true);
    if (!is_array($data) || !isset($data['results']) || !is_array($data['results'])) {
        fwrite(STDERR, "skipping malformed dump: $path\n");
        continue;
    }
    foreach ($data['results'] as $r) {
        if (is_array($r) && isset($r['testId'])) {
            $rows[(string) $r['testId']] = $r;
        }
    }
}
ksort($rows);

/**
 * Per-engine cell for one result: [symbol, aeFraction|null, present].
 *
 * @param array<string, mixed> $r
 * @return array{0: string, 1: ?float, 2: bool}
 */
function engineCell(array $r, string $engine): array
{
    if (($r['verdict'] ?? null) === 'harness_error') {
        return ['err', null, false];
    }
    // Prefer `oursAll` (our AE vs EVERY engine that rendered, consensus or
    // not) so an engine dropped from consensus still shows its divergence
    // rather than a misleading "unavailable". Fall back to `ours`
    // (consensus-only) for dumps produced before oursAll existed.
    $ours = is_array($r['oursAll'] ?? null) ? $r['oursAll'] : [];
    if ($ours === []) {
        $ours = is_array($r['ours'] ?? null) ? $r['ours'] : [];
    }
    if (!array_key_exists($engine, $ours) || !is_numeric($ours[$engine])) {
        return ['–', null, false];
    }
    $ae = (float) $ours[$engine];
    $budget = (float) ($r['fuzzBudget'] ?? 0.005);
    return [$ae <= $budget ? '✓' : '✗', $ae, true];
}

function cellText(string $sym, ?float $ae): string
{
    if ($ae === null) {
        return $sym;
    }
    return sprintf('%s %.2f%%', $sym, $ae * 100);
}

// Per-engine tallies: matched / compared (tests where the engine was present).
$tally = [];
foreach (ENGINES as $e) {
    $tally[$e] = ['match' => 0, 'compared' => 0];
}
$verdictTally = ['pass' => 0, 'fail' => 0, 'skip_disagree' => 0, 'insufficient_engines' => 0, 'harness_error' => 0];

$mdRows = [];
$csvRows = [];
foreach ($rows as $testId => $r) {
    $verdict = (string) ($r['verdict'] ?? 'harness_error');
    $verdictTally[$verdict] = ($verdictTally[$verdict] ?? 0) + 1;

    $cells = [];
    $anyFail = false;
    foreach (ENGINES as $e) {
        [$sym, $ae, $present] = engineCell($r, $e);
        if ($present) {
            $tally[$e]['compared']++;
            if ($sym === '✓') {
                $tally[$e]['match']++;
            } else {
                $anyFail = true;
            }
        }
        $cells[$e] = [$sym, $ae];
    }
    if ($failsOnly && !$anyFail && $verdict === 'pass') {
        continue;
    }

    $mdRow = [$testId];
    $csvRow = [$testId];
    foreach (ENGINES as $e) {
        $mdRow[] = cellText($cells[$e][0], $cells[$e][1]);
        $csvRow[] = $cells[$e][1] === null
            ? $cells[$e][0]
            : sprintf('%s %.3f', $cells[$e][0], $cells[$e][1]);
    }
    $mdRow[] = $verdict;
    $csvRow[] = $verdict;
    $mdRows[] = $mdRow;
    $csvRows[] = $csvRow;
}

// ---- Markdown ----
$header = ['Test', 'Chromium (Blink)', 'Firefox (Gecko)', 'WebKit', 'Consensus'];
$out = "# Cross-browser per-engine matrix\n\n";
$out .= sprintf(
    "%d test%s. Cell = does our PDF match that engine's print render within budget (✓/✗ with pixel AE; – unavailable).\n\n",
    count($rows),
    count($rows) === 1 ? '' : 's',
);
$out .= '| ' . implode(' | ', $header) . " |\n";
$out .= '|' . str_repeat(' --- |', count($header)) . "\n";
foreach ($mdRows as $row) {
    $out .= '| ' . implode(' | ', $row) . " |\n";
}
$out .= "\n## Per-engine totals (our render vs each engine)\n\n";
$out .= "| Engine | Matched | Compared | Match rate |\n|  ---  |  ---  |  ---  |  ---  |\n";
foreach (ENGINES as $e) {
    $c = $tally[$e]['compared'];
    $m = $tally[$e]['match'];
    $out .= sprintf(
        "| %s | %d | %d | %s |\n",
        $e,
        $m,
        $c,
        $c > 0 ? sprintf('%.1f%%', 100 * $m / $c) : 'n/a',
    );
}
$out .= "\n## Consensus verdict tally\n\n";
foreach ($verdictTally as $v => $n) {
    $out .= sprintf("- %s: %d\n", $v, $n);
}
echo $out;

// ---- CSV ----
if ($csvOut !== null) {
    $lines = [implode(',', ['test', 'chromium', 'firefox', 'webkit', 'consensus'])];
    foreach ($csvRows as $row) {
        $lines[] = implode(',', array_map(
            static fn(string $c): string => '"' . str_replace('"', '""', $c) . '"',
            $row,
        ));
    }
    LocalFilesystem::writeFile($csvOut, implode("\n", $lines) . "\n");
    fwrite(STDERR, "wrote CSV: $csvOut\n");
}
