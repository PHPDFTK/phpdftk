<?php

declare(strict_types=1);

namespace Phpdftk\Text;

use Phpdftk\FontParser\FontFaceData;

/**
 * OpenType text shaper.
 *
 * Phase-1 implementation: cmap-based codepoint → glyph mapping, GSUB
 * ligature substitution via the font-parser's `TextShaper::applyLigatures`,
 * and GPOS kerning via the font's `kernPairs` table (legacy kern; modern
 * `GPOS` lookups will land in Phase 2 alongside Arabic/Indic shaping).
 *
 * For glyphs whose codepoint isn't in the font's `fullUnicodeToGid` map,
 * the shaper emits glyph 0 (`.notdef`). Higher-level paragraph shaping —
 * which would attempt font fallback before falling back to `.notdef` —
 * lives at the layout layer once font stacks are wired in.
 *
 * Advances are reported in PDF user-space units (1pt = 1/72in), already
 * scaled by `fontSizePt / unitsPerEm`. Layout consumers do not need to
 * know about font design units.
 */
final class Shaper
{
    public function shapeRun(string $text, ShapingContext $context): ShapedRun
    {
        $font = $context->font;
        if ($text === '') {
            return new ShapedRun(
                $font,
                $context->fontSizePt,
                $context->direction,
                [],
                0.0,
            );
        }

        $codepoints = self::decodeUtf8($text);
        // Unicode Default_Ignorable_Code_Point — zero-width formatting /
        // control characters (ZWSP, ZWNJ/ZWJ, bidi controls, word joiner,
        // BOM, variation selectors, …) render as no visible glyph and add
        // no advance (so they also get no letter-spacing). Drop them before
        // GID lookup so they don't fall through to a `.notdef` box.
        $codepoints = array_values(array_filter(
            $codepoints,
            static fn(array $cp): bool => !self::isDefaultIgnorable($cp['codepoint']),
        ));
        if ($codepoints === []) {
            return new ShapedRun($font, $context->fontSizePt, $context->direction, [], 0.0);
        }
        $gids = [];
        foreach ($codepoints as $cp) {
            $gids[] = self::lookupGid($cp['codepoint'], $font);
        }

        // Track which codepoint each output GID came from, so ligature
        // substitution can preserve byte offsets for the consolidated glyph.
        // `sourceMap` is per output-glyph index → [startCpIdx, endCpIdxExclusive].
        $sourceMap = [];
        for ($i = 0; $i < count($gids); $i++) {
            $sourceMap[$i] = [$i, $i + 1];
        }

        if (in_array('liga', $context->features, true) && $font->ligatures !== null) {
            [$gids, $sourceMap] = self::applyLigaturesWithMap($gids, $sourceMap, $font->ligatures);
        }

        $scale = $context->fontSizePt / ($font->unitsPerEm > 0 ? $font->unitsPerEm : 1000);
        $applyKern = in_array('kern', $context->features, true) && $font->kernPairs !== null;
        $kernPairs = $font->kernPairs ?? [];

        $glyphs = [];
        $totalAdvance = 0.0;
        $count = count($gids);
        for ($i = 0; $i < $count; $i++) {
            $gid = $gids[$i];
            $advanceUnits = $font->glyphWidths[$gid] ?? 0;
            if ($applyKern && $i + 1 < $count) {
                $next = $gids[$i + 1];
                $adjust = $kernPairs[$gid][$next] ?? 0;
                $advanceUnits += $adjust;
            }
            $advanceX = $advanceUnits * $scale;
            [$startIdx, $endIdx] = $sourceMap[$i];
            $startByte = $codepoints[$startIdx]['byteOffset'];
            $endByte = $endIdx < count($codepoints)
                ? $codepoints[$endIdx]['byteOffset']
                : strlen($text);

            $glyphs[] = new ShapedGlyph(
                glyphId: $gid,
                sourceOffset: $startByte,
                sourceLength: $endByte - $startByte,
                advanceX: $advanceX,
            );
            $totalAdvance += $advanceX;
        }

        return new ShapedRun(
            $font,
            $context->fontSizePt,
            $context->direction,
            $glyphs,
            $totalAdvance,
        );
    }

    private static function lookupGid(int $codepoint, FontFaceData $font): int
    {
        return $font->fullUnicodeToGid[$codepoint] ?? 0;
    }

    /**
     * Unicode `Default_Ignorable_Code_Point` (DerivedCoreProperties) — the
     * formatting / control characters that must render as no visible glyph
     * and zero advance. Excludes U+00AD SOFT HYPHEN (handled by the
     * line-break / hyphenation logic, which needs to see it).
     */
    private static function isDefaultIgnorable(int $cp): bool
    {
        return $cp === 0x034F                       // combining grapheme joiner
            || $cp === 0x061C                       // arabic letter mark
            || ($cp >= 0x115F && $cp <= 0x1160)     // hangul choseong/jungseong fillers
            || ($cp >= 0x17B4 && $cp <= 0x17B5)     // khmer inherent vowels
            || ($cp >= 0x180B && $cp <= 0x180F)     // mongolian free variation selectors + vowel sep
            || ($cp >= 0x200B && $cp <= 0x200F)     // ZWSP, ZWNJ, ZWJ, LRM, RLM
            || ($cp >= 0x202A && $cp <= 0x202E)     // bidi embedding / override
            || ($cp >= 0x2060 && $cp <= 0x206F)     // word joiner, invisible ops, deprecated fmt
            || $cp === 0x3164                       // hangul filler
            || ($cp >= 0xFE00 && $cp <= 0xFE0F)     // variation selectors
            || $cp === 0xFEFF                       // zero width no-break space (BOM)
            || $cp === 0xFFA0                       // halfwidth hangul filler
            || ($cp >= 0xFFF0 && $cp <= 0xFFF8)     // reserved
            || ($cp >= 0x1BCA0 && $cp <= 0x1BCA3)   // shorthand format controls
            || ($cp >= 0x1D173 && $cp <= 0x1D17A)   // musical symbols beam/slur controls
            || ($cp >= 0xE0000 && $cp <= 0xE0FFF);  // tags + variation selectors supplement
    }

    /**
     * Run the existing `FontTextShaper::applyLigatures` pass and keep a
     * parallel sourceMap so each surviving glyph still points back to the
     * byte range in the original input.
     *
     * @param list<int> $gids
     * @param array<int, array{int, int}> $sourceMap
     * @param array<int, list<array{components: int[], ligature: int}>> $ligatures
     * @return array{list<int>, array<int, array{int, int}>}
     */
    private static function applyLigaturesWithMap(array $gids, array $sourceMap, array $ligatures): array
    {
        if ($gids === [] || $ligatures === []) {
            return [$gids, $sourceMap];
        }
        $outGids = [];
        $outMap = [];
        $i = 0;
        $len = count($gids);
        while ($i < $len) {
            $gid = $gids[$i];
            $matched = false;
            if (isset($ligatures[$gid])) {
                foreach ($ligatures[$gid] as $rule) {
                    $components = $rule['components'];
                    $compLen = count($components);
                    if ($i + $compLen >= $len) {
                        continue;
                    }
                    $allMatch = true;
                    for ($j = 0; $j < $compLen; $j++) {
                        if ($gids[$i + 1 + $j] !== $components[$j]) {
                            $allMatch = false;
                            break;
                        }
                    }
                    if ($allMatch) {
                        $outIdx = count($outGids);
                        $outGids[] = $rule['ligature'];
                        $outMap[$outIdx] = [
                            $sourceMap[$i][0],
                            $sourceMap[$i + $compLen][1],
                        ];
                        $i += 1 + $compLen;
                        $matched = true;
                        break;
                    }
                }
            }
            if (!$matched) {
                $outIdx = count($outGids);
                $outGids[] = $gid;
                $outMap[$outIdx] = $sourceMap[$i];
                $i++;
            }
        }
        return [$outGids, $outMap];
    }

    /**
     * @return list<array{codepoint: int, byteOffset: int}>
     */
    private static function decodeUtf8(string $text): array
    {
        $out = [];
        $bytes = strlen($text);
        $i = 0;
        while ($i < $bytes) {
            $byte = ord($text[$i]);
            if ($byte < 0x80) {
                $out[] = ['codepoint' => $byte, 'byteOffset' => $i];
                $i++;
            } elseif ($byte < 0xC0) {
                $out[] = ['codepoint' => 0xFFFD, 'byteOffset' => $i];
                $i++;
            } elseif ($byte < 0xE0) {
                $cp = (($byte & 0x1F) << 6) | (ord($text[$i + 1] ?? "\x00") & 0x3F);
                $out[] = ['codepoint' => $cp, 'byteOffset' => $i];
                $i += 2;
            } elseif ($byte < 0xF0) {
                $cp = (($byte & 0x0F) << 12)
                    | ((ord($text[$i + 1] ?? "\x00") & 0x3F) << 6)
                    | (ord($text[$i + 2] ?? "\x00") & 0x3F);
                $out[] = ['codepoint' => $cp, 'byteOffset' => $i];
                $i += 3;
            } else {
                $cp = (($byte & 0x07) << 18)
                    | ((ord($text[$i + 1] ?? "\x00") & 0x3F) << 12)
                    | ((ord($text[$i + 2] ?? "\x00") & 0x3F) << 6)
                    | (ord($text[$i + 3] ?? "\x00") & 0x3F);
                $out[] = ['codepoint' => $cp, 'byteOffset' => $i];
                $i += 4;
            }
        }
        return $out;
    }
}
