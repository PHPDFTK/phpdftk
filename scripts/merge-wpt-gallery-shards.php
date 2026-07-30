<?php

declare(strict_types=1);

/**
 * Merge WPT-gallery shard outputs into one manifest + image set.
 *
 * Each shard directory (produced by `build-wpt-gallery.php --shard=K/N`)
 * holds a `manifest.json` plus an `img/` dir. Shards are disjoint by test
 * id, so merging is a concatenation of the `tests` arrays and a union of
 * the images. Used by the CI `publish-wpt-gallery` job before pushing to
 * the `_wpt-gallery` orphan branch.
 *
 * Usage:
 *   php scripts/merge-wpt-gallery-shards.php <shards-dir> <out-dir>
 *
 * <shards-dir> contains one subdirectory per downloaded shard artifact
 * (e.g. wpt-gallery-shard-1/, wpt-gallery-shard-2/, …), each with the
 * generator's output layout. <out-dir>/{manifest.json,img/} is written.
 */

use Phpdftk\Filesystem\LocalFilesystem;

require __DIR__ . '/../vendor/autoload.php';

$shardsDir = $argv[1] ?? null;
$outDir = $argv[2] ?? null;
if ($shardsDir === null || $outDir === null) {
    fwrite(STDERR, "usage: merge-wpt-gallery-shards.php <shards-dir> <out-dir>\n");
    exit(1);
}
if (!is_dir($shardsDir)) {
    fwrite(STDERR, "merge: shards dir not found: {$shardsDir}\n");
    exit(1);
}

$outImg = $outDir . '/img';
if (!is_dir($outImg)) {
    @mkdir($outImg, 0o777, true);
}

$tests = [];
$summary = ['pass' => 0, 'fail' => 0, 'noRef' => 0, 'renderError' => 0, 'unknown' => 0];
$filters = [];
$shardCount = 0;

foreach (glob($shardsDir . '/*', GLOB_ONLYDIR) ?: [] as $shard) {
    $manifestPath = $shard . '/manifest.json';
    if (!is_file($manifestPath)) {
        // Some artifact layouts nest one directory deeper.
        $nested = glob($shard . '/*/manifest.json') ?: [];
        if ($nested === []) {
            fwrite(STDERR, "merge: no manifest in {$shard} — skipping\n");
            continue;
        }
        $manifestPath = $nested[0];
        $shard = dirname($manifestPath);
    }
    $shardCount++;

    /** @var array{filter?:?string,summary?:array<string,int>,tests?:list<array<string,mixed>>} $data */
    $data = json_decode(LocalFilesystem::readFile($manifestPath, 'shard manifest'), true);
    if (!is_array($data)) {
        fwrite(STDERR, "merge: malformed manifest {$manifestPath} — skipping\n");
        continue;
    }
    if (isset($data['filter']) && is_string($data['filter'])) {
        $filters[$data['filter']] = true;
    }
    foreach (($data['summary'] ?? []) as $k => $v) {
        if (isset($summary[$k]) && is_int($v)) {
            $summary[$k] += $v;
        }
    }
    foreach (($data['tests'] ?? []) as $test) {
        $tests[] = $test;
    }

    // Copy this shard's images into the merged img/ dir.
    foreach (glob($shard . '/img/*') ?: [] as $img) {
        LocalFilesystem::writeFile(
            $outImg . '/' . basename($img),
            LocalFilesystem::readFile($img, 'shard image'),
            true,
        );
    }
}

// Stable order by test id so the grid is deterministic across runs.
usort($tests, static fn(array $a, array $b): int => strcmp((string) ($a['testId'] ?? ''), (string) ($b['testId'] ?? '')));

$manifest = [
    'schema' => 1,
    'generatedAt' => gmdate('c'),
    'filter' => implode(' ', array_keys($filters)) ?: null,
    'shard' => null,
    'count' => count($tests),
    'summary' => $summary,
    'tests' => $tests,
];
LocalFilesystem::writeFile(
    $outDir . '/manifest.json',
    json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n",
);

fwrite(STDERR, "merged {$shardCount} shards -> " . count($tests) . " tests\n");
