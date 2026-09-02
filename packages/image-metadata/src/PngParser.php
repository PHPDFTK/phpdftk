<?php

declare(strict_types=1);

namespace Phpdftk\ImageMetadata;

use Phpdftk\Filesystem\LocalFilesystem;

/**
 * Parse PNG IHDR chunk for dimensions, bit depth, and color type.
 *
 * Also extracts ICC profiles from iCCP chunks. PNG alpha channels
 * are detected since PDF handles transparency via SMask, not inline.
 */
final class PngParser
{
    public static function parseFile(string $path): ImageInfo
    {
        $fh = LocalFilesystem::openReadable($path, "image file");
        try {
            $data = fread($fh, filesize($path));
        } finally {
            fclose($fh);
        }
        return self::parse($data);
    }

    /**
     * Decode an 8-bit alpha PNG (color type 4 = grayscale+alpha,
     * type 6 = RGB+alpha) into separate colour and alpha streams.
     * The PDF caller then emits the colour as the main Image
     * XObject and the alpha as an `/SMask` reference attached to
     * it. Returns null for non-alpha PNGs, non-8-bit depths, or
     * any decode failure (corrupt IDAT, bad filter byte, etc.).
     *
     * Output streams are raw (uncompressed) per-pixel bytes —
     * colour: 1 byte/px (grayscale) or 3 bytes/px (RGB).
     * alpha:  1 byte/px (grayscale always).
     *
     * The caller is expected to FlateDecode-compress them before
     * embedding in the PDF.
     *
     * @return array{colour: string, alpha: string, width: int, height: int, components: int}|null
     */
    public static function decodeAlphaPng(string $data): ?array
    {
        $info = self::parse($data);
        $colorType = self::peekColorType($data);
        if ($colorType === null || $info->bitsPerComponent !== 8) {
            return null;
        }
        $components = match ($colorType) {
            4 => 1, // grayscale + alpha → 2 bpp
            6 => 3, // RGB + alpha       → 4 bpp
            default => null,
        };
        if ($components === null) {
            return null;
        }
        $idat = self::extractIdatData($data);
        if ($idat === null) {
            return null;
        }
        $decompressed = @gzuncompress($idat);
        if ($decompressed === false) {
            return null;
        }
        $bpp = $components + 1; // colour bytes + 1 alpha byte
        $raster = self::unfilterRaster(
            $decompressed,
            $info->width,
            $info->height,
            $bpp,
            self::peekInterlace($data) ?? 0,
        );
        if ($raster === null) {
            return null;
        }
        // Split the unfiltered raster into colour + alpha planes.
        $colour = '';
        $alpha = '';
        $pixels = $info->width * $info->height;
        for ($i = 0; $i < $pixels; $i++) {
            $pxBase = $i * $bpp;
            $colour .= substr($raster, $pxBase, $components);
            $alpha .= $raster[$pxBase + $components];
        }
        return [
            'colour' => $colour,
            'alpha' => $alpha,
            'width' => $info->width,
            'height' => $info->height,
            'components' => $components,
        ];
    }

    /**
     * Decode a non-alpha 8-bit PNG (colour type 0 grayscale or 2 RGB)
     * to a flat raster.
     *
     * Only needed for INTERLACED images: a non-interlaced PNG's IDAT
     * can be handed straight to PDF as FlateDecode with `/Predictor
     * 15`, but Adam7 data is seven sub-images rather than scanlines,
     * so the PDF predictor cannot read it and the image must be
     * decoded here and re-emitted.
     *
     * @return array{colour: string, width: int, height: int, components: int}|null
     */
    public static function decodeOpaquePng(string $data): ?array
    {
        $info = self::parse($data);
        $colorType = self::peekColorType($data);
        if ($colorType === null || $info->bitsPerComponent !== 8) {
            return null;
        }
        $components = match ($colorType) {
            0 => 1, // grayscale
            2 => 3, // RGB
            default => null,
        };
        if ($components === null) {
            return null;
        }
        $idat = self::extractIdatData($data);
        if ($idat === null) {
            return null;
        }
        $decompressed = @gzuncompress($idat);
        if ($decompressed === false) {
            return null;
        }
        $raster = self::unfilterRaster(
            $decompressed,
            $info->width,
            $info->height,
            $components,
            self::peekInterlace($data) ?? 0,
        );
        if ($raster === null) {
            return null;
        }
        return [
            'colour' => $raster,
            'width' => $info->width,
            'height' => $info->height,
            'components' => $components,
        ];
    }

    /**
     * PNG spec §8.2 — the seven Adam7 interlace passes, each as
     * `[xStart, yStart, xStep, yStep]`. Every pass is a self-contained
     * sub-image with its OWN filter state, so each is unfiltered
     * independently and then scattered into the full raster.
     */
    private const ADAM7_PASSES = [
        [0, 0, 8, 8],
        [4, 0, 8, 8],
        [0, 4, 4, 8],
        [2, 0, 4, 4],
        [0, 2, 2, 4],
        [1, 0, 2, 2],
        [0, 1, 1, 2],
    ];

    /**
     * Peek the PNG's interlace method (IHDR byte 12): 0 = none,
     * 1 = Adam7. Same direct-read trick as {@see peekColorType}.
     */
    private static function peekInterlace(string $data): ?int
    {
        if (strlen($data) < 8 + 8 + 13 || substr($data, 0, 8) !== "\x89PNG\r\n\x1A\n") {
            return null;
        }
        if (substr($data, 12, 4) !== 'IHDR') {
            return null;
        }
        return ord($data[8 + 8 + 12]);
    }

    /**
     * Unfilter a decompressed PNG datastream into a flat, filter-byte-
     * free raster of `$width * $height * $bpp` bytes.
     *
     * Handles both interlace methods. For Adam7 (`$interlace === 1`)
     * each of the seven passes is unfiltered as its own sub-image and
     * its pixels scattered to their final positions — without this,
     * an interlaced PNG is read as though the pass data were one
     * contiguous raster, which renders as noise.
     *
     * Byte-for-byte identical to the previous single-pass behaviour
     * when `$interlace === 0`. Requires whole-byte pixels (bit depth
     * 8), which every caller already enforces.
     */
    private static function unfilterRaster(
        string $data,
        int $width,
        int $height,
        int $bpp,
        int $interlace,
    ): ?string {
        if ($interlace === 0) {
            $pass = self::unfilterPass($data, 0, $width, $height, $bpp);
            return $pass === null ? null : $pass['raster'];
        }
        if ($interlace !== 1) {
            return null;
        }
        $raster = str_repeat("\x00", $width * $height * $bpp);
        $offset = 0;
        foreach (self::ADAM7_PASSES as [$xStart, $yStart, $xStep, $yStep]) {
            // Ceiling division — a pass covering no pixels is skipped
            // entirely and contributes no bytes to the stream.
            $passWidth = intdiv($width - $xStart + $xStep - 1, $xStep);
            $passHeight = intdiv($height - $yStart + $yStep - 1, $yStep);
            if ($passWidth <= 0 || $passHeight <= 0) {
                continue;
            }
            $pass = self::unfilterPass($data, $offset, $passWidth, $passHeight, $bpp);
            if ($pass === null) {
                return null;
            }
            $offset = $pass['offset'];
            $passRaster = $pass['raster'];
            for ($py = 0; $py < $passHeight; $py++) {
                $targetY = $yStart + $py * $yStep;
                for ($px = 0; $px < $passWidth; $px++) {
                    $targetX = $xStart + $px * $xStep;
                    $src = ($py * $passWidth + $px) * $bpp;
                    $dst = ($targetY * $width + $targetX) * $bpp;
                    for ($b = 0; $b < $bpp; $b++) {
                        $raster[$dst + $b] = $passRaster[$src + $b];
                    }
                }
            }
        }
        return $raster;
    }

    /**
     * Reverse the per-row PNG filters (spec §9.2) for one sub-image of
     * `$width x $height` pixels starting at `$offset`. Returns the
     * unfiltered bytes plus the offset just past the data consumed, so
     * the caller can walk consecutive Adam7 passes.
     *
     * @return array{raster: string, offset: int}|null
     */
    private static function unfilterPass(
        string $data,
        int $offset,
        int $width,
        int $height,
        int $bpp,
    ): ?array {
        $stride = $width * $bpp;
        if (strlen($data) < $offset + ($stride + 1) * $height) {
            return null;
        }
        $raster = '';
        $prev = str_repeat("\x00", $stride);
        for ($y = 0; $y < $height; $y++) {
            $filter = ord($data[$offset]);
            $offset++;
            $current = '';
            for ($x = 0; $x < $stride; $x++) {
                $px = ord($data[$offset + $x]);
                $left = $x >= $bpp ? ord($current[$x - $bpp]) : 0;
                $up = ord($prev[$x]);
                $upLeft = $x >= $bpp ? ord($prev[$x - $bpp]) : 0;
                $unfiltered = match ($filter) {
                    0 => $px,
                    1 => ($px + $left) & 0xFF,
                    2 => ($px + $up) & 0xFF,
                    3 => ($px + (($left + $up) >> 1)) & 0xFF,
                    4 => ($px + self::paeth($left, $up, $upLeft)) & 0xFF,
                    default => -1,
                };
                if ($unfiltered < 0) {
                    return null;
                }
                $current .= chr($unfiltered);
            }
            $offset += $stride;
            $raster .= $current;
            $prev = $current;
        }
        return ['raster' => $raster, 'offset' => $offset];
    }

    /**
     * Peek the PNG's color type without re-running the full parser.
     * IHDR is always the first chunk after the 8-byte signature, so
     * we read it directly.
     */
    private static function peekColorType(string $data): ?int
    {
        if (strlen($data) < 8 + 8 + 13 || substr($data, 0, 8) !== "\x89PNG\r\n\x1A\n") {
            return null;
        }
        if (substr($data, 12, 4) !== 'IHDR') {
            return null;
        }
        return ord($data[8 + 8 + 9]);
    }

    private static function paeth(int $a, int $b, int $c): int
    {
        $p = $a + $b - $c;
        $pa = abs($p - $a);
        $pb = abs($p - $b);
        $pc = abs($p - $c);
        if ($pa <= $pb && $pa <= $pc) {
            return $a;
        }
        if ($pb <= $pc) {
            return $b;
        }
        return $c;
    }

    /**
     * Decode an 8-bit indexed-colour PNG (color type 3) into the
     * separate colour + alpha streams a PDF Image XObject embeds.
     * Walks the IDAT data through PNG filter reversal, indexes each
     * pixel into the PLTE palette, and (when the optional tRNS
     * chunk is present) looks up per-palette-index alpha.
     *
     * Returns null for non-indexed PNGs, unsupported bit depths
     * (anything outside 1 / 2 / 4 / 8), missing PLTE, or any decode
     * failure.
     *
     * Output: colour = 3 bytes/px (RGB). alpha = 1 byte/px when
     * tRNS is present; null when the palette is fully opaque (the
     * caller skips the SMask).
     *
     * @return array{colour: string, alpha: ?string, width: int, height: int}|null
     */
    public static function decodeIndexedPng(string $data): ?array
    {
        $info = self::parse($data);
        $colorType = self::peekColorType($data);
        if ($colorType !== 3 || !in_array($info->bitsPerComponent, [1, 2, 4, 8], true)) {
            return null;
        }
        $palette = self::extractChunk($data, 'PLTE');
        if ($palette === null || strlen($palette) % 3 !== 0 || $palette === '') {
            return null;
        }
        $trns = self::extractChunk($data, 'tRNS');
        $idat = self::extractIdatData($data);
        if ($idat === null) {
            return null;
        }
        $decompressed = @gzuncompress($idat);
        if ($decompressed === false) {
            return null;
        }
        // PNG packs sub-byte pixels MSB-first into the smallest whole
        // number of bytes per scanline. Filter bytes precede the
        // packed row, so we walk the packed stride byte-by-byte for
        // filter reversal, then unpack into 1-byte-per-pixel indices.
        $bitDepth = $info->bitsPerComponent;
        $stride = (int) ceil(($info->width * $bitDepth) / 8);
        $expected = ($stride + 1) * $info->height;
        if (strlen($decompressed) < $expected) {
            return null;
        }
        $bpp = 1; // filter neighbours operate on packed bytes for sub-8 depths
        $colour = '';
        $alpha = '';
        $hasTransparent = false;
        $prev = str_repeat("\x00", $stride);
        $offset = 0;
        $mask = (1 << $bitDepth) - 1;
        for ($y = 0; $y < $info->height; $y++) {
            $filter = ord($decompressed[$offset]);
            $offset++;
            $current = '';
            for ($x = 0; $x < $stride; $x++) {
                $px = ord($decompressed[$offset + $x]);
                $left = $x >= $bpp ? ord($current[$x - $bpp]) : 0;
                $up = ord($prev[$x]);
                $upLeft = $x >= $bpp ? ord($prev[$x - $bpp]) : 0;
                $unfiltered = match ($filter) {
                    0 => $px,
                    1 => ($px + $left) & 0xFF,
                    2 => ($px + $up) & 0xFF,
                    3 => ($px + (($left + $up) >> 1)) & 0xFF,
                    4 => ($px + self::paeth($left, $up, $upLeft)) & 0xFF,
                    default => -1,
                };
                if ($unfiltered < 0) {
                    return null;
                }
                $current .= chr($unfiltered);
            }
            $offset += $stride;
            // Unpack packed indices MSB-first into per-pixel indices,
            // then walk those for palette + alpha lookup.
            for ($x = 0; $x < $info->width; $x++) {
                $bitIndex = $x * $bitDepth;
                $byteIndex = intdiv($bitIndex, 8);
                $shift = 8 - $bitDepth - ($bitIndex % 8);
                $idx = (ord($current[$byteIndex]) >> $shift) & $mask;
                $paletteOffset = $idx * 3;
                if ($paletteOffset + 3 > strlen($palette)) {
                    // Out-of-range index — paint with palette[0] as
                    // a tolerant fallback (matches some browsers'
                    // recovery posture).
                    $paletteOffset = 0;
                }
                $colour .= substr($palette, $paletteOffset, 3);
                if ($trns !== null) {
                    $a = $idx < strlen($trns) ? ord($trns[$idx]) : 0xFF;
                    $alpha .= chr($a);
                    if ($a !== 0xFF) {
                        $hasTransparent = true;
                    }
                }
            }
            $prev = $current;
        }
        return [
            'colour' => $colour,
            'alpha' => $hasTransparent ? $alpha : null,
            'width' => $info->width,
            'height' => $info->height,
        ];
    }

    /**
     * Find and return the first matching chunk payload. Used for
     * one-off lookups (`PLTE`, `tRNS`) that don't appear in the
     * critical IHDR + IDAT + IEND path the full parser walks.
     */
    private static function extractChunk(string $data, string $chunkType): ?string
    {
        $len = strlen($data);
        if ($len < 8 || substr($data, 0, 8) !== "\x89PNG\r\n\x1A\n") {
            return null;
        }
        $pos = 8;
        while ($pos + 12 <= $len) {
            $chunkLen = unpack('N', substr($data, $pos, 4))[1];
            $type = substr($data, $pos + 4, 4);
            if ($type === $chunkType) {
                return substr($data, $pos + 8, $chunkLen);
            }
            if ($type === 'IEND') {
                return null;
            }
            $pos += 12 + $chunkLen;
        }
        return null;
    }

    /**
     * Extract the concatenated `IDAT` chunk payload from a PNG.
     * The payload is already DEFLATE-compressed PNG-filter-coded
     * pixel data, suitable for embedding in a PDF Image XObject
     * with `/Filter /FlateDecode` + `/DecodeParms <<Predictor 15
     * Columns W Colors N BitsPerComponent B>>` — PDF readers
     * decompress + unfilter via the predictor without an
     * intermediate raw-RGB buffer.
     *
     * Returns null when the PNG signature is invalid or no IDAT
     * chunks are present.
     */
    public static function extractIdatData(string $data): ?string
    {
        $len = strlen($data);
        if ($len < 8 || substr($data, 0, 8) !== "\x89PNG\r\n\x1A\n") {
            return null;
        }
        $pos = 8;
        $idat = '';
        while ($pos + 12 <= $len) {
            $chunkLen = unpack('N', substr($data, $pos, 4))[1];
            $chunkType = substr($data, $pos + 4, 4);
            if ($chunkType === 'IDAT' && $chunkLen > 0) {
                $idat .= substr($data, $pos + 8, $chunkLen);
            } elseif ($chunkType === 'IEND') {
                break;
            }
            $pos += 12 + $chunkLen;
        }
        return $idat === '' ? null : $idat;
    }

    public static function parse(string $data): ImageInfo
    {
        $len = strlen($data);

        // Verify PNG signature (8 bytes)
        if ($len < 8 || substr($data, 0, 8) !== "\x89PNG\r\n\x1A\n") {
            throw new \RuntimeException('Not a valid PNG file');
        }

        $pos = 8;
        $width = 0;
        $height = 0;
        $bitDepth = 8;
        $colorType = 2;
        $xDpi = null;
        $yDpi = null;
        $iccProfile = null;

        while ($pos + 12 <= $len) {
            $chunkLen  = unpack('N', substr($data, $pos, 4))[1];
            $chunkType = substr($data, $pos + 4, 4);
            $chunkData = substr($data, $pos + 8, $chunkLen);
            $pos += 12 + $chunkLen;

            if ($chunkType === 'IHDR' && strlen($chunkData) >= 13) {
                $width    = unpack('N', substr($chunkData, 0, 4))[1];
                $height   = unpack('N', substr($chunkData, 4, 4))[1];
                $bitDepth = ord($chunkData[8]);
                $colorType = ord($chunkData[9]);
            } elseif ($chunkType === 'pHYs' && strlen($chunkData) >= 9) {
                $xPixelsPerUnit = unpack('N', substr($chunkData, 0, 4))[1];
                $yPixelsPerUnit = unpack('N', substr($chunkData, 4, 4))[1];
                $unit = ord($chunkData[8]);
                if ($unit === 1 && $xPixelsPerUnit > 0 && $yPixelsPerUnit > 0) {
                    // Unit is meters; convert to DPI
                    $xDpi = (int) round($xPixelsPerUnit / 39.3701);
                    $yDpi = (int) round($yPixelsPerUnit / 39.3701);
                }
            } elseif ($chunkType === 'iCCP' && strlen($chunkData) > 2) {
                // iCCP chunk: null-terminated profile name, 1-byte compression method, compressed data
                $nullPos = strpos($chunkData, "\x00");
                if ($nullPos !== false && $nullPos + 2 <= strlen($chunkData)) {
                    // Skip profile name + null byte + compression method byte (always 0 = deflate)
                    $compressedData = substr($chunkData, $nullPos + 2);
                    if ($compressedData !== '') {
                        $decompressed = @gzuncompress($compressedData);
                        if ($decompressed !== false) {
                            $iccProfile = $decompressed;
                        }
                    }
                }
            } elseif ($chunkType === 'IEND') {
                break;
            }
        }

        [$colorSpace, $hasAlpha] = match ($colorType) {
            0 => ['DeviceGray', false],
            2 => ['DeviceRGB', false],
            3 => ['DeviceRGB', false],  // indexed — treat as RGB
            4 => ['DeviceGray', true],
            6 => ['DeviceRGB', true],
            default => ['DeviceRGB', false],
        };

        return new ImageInfo(
            width: $width,
            height: $height,
            colorSpace: $colorSpace,
            bitsPerComponent: $bitDepth,
            format: 'png',
            hasAlpha: $hasAlpha,
            xDpi: $xDpi,
            yDpi: $yDpi,
            iccProfile: $iccProfile,
        );
    }
}
