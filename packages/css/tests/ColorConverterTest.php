<?php

declare(strict_types=1);

namespace Phpdftk\Css\Tests;

use Phpdftk\Css\Value\Color;
use Phpdftk\Css\Value\ColorConverter;
use Phpdftk\Css\Value\ColorSpace;
use Phpdftk\Css\Value\HueInterpolation;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Covers {@see ColorConverter::toSrgb} across every CSS Color 4/5 storage
 * space. Reliable anchors: each space's white converts to sRGB white and
 * its black to sRGB black; specific hues / gammas pin the math; edge cases
 * exercise gamut clipping, the LCH/OKLCH chroma binary-search, hue
 * wrapping, gray normalisation, and alpha passthrough.
 */
final class ColorConverterTest extends TestCase
{
    private const D65_WHITE = [0.9504559270516716, 1.0, 1.0890577507598784];
    private const D50_WHITE = [0.9642956764295677, 1.0, 0.8251046025104602];

    private static function assertSrgb(
        Color $out,
        float $r,
        float $g,
        float $b,
        float $delta = 0.01,
        ?float $alpha = null,
    ): void {
        self::assertSame(ColorSpace::sRGB, $out->space, 'output must be sRGB-space');
        self::assertEqualsWithDelta($r, $out->r, $delta, 'red');
        self::assertEqualsWithDelta($g, $out->g, $delta, 'green');
        self::assertEqualsWithDelta($b, $out->b, $delta, 'blue');
        if ($alpha !== null) {
            self::assertSame($alpha, $out->a, 'alpha must pass through unchanged');
        }
    }

    // ---- Negative / edge cases first -------------------------------------

    public function testXyzAboveGamutClipsToOne(): void
    {
        // Components beyond the sRGB cube must clamp to 1 (CSS Color 4 §13
        // proper gamut-mapping is a follow-up; clip is the documented
        // behaviour). XYZ(2,2,2) blows past white on every channel.
        $out = ColorConverter::toSrgb(new Color(2.0, 2.0, 2.0, 1.0, ColorSpace::XYZD65));
        self::assertSrgb($out, 1.0, 1.0, 1.0, 0.0001);
    }

    public function testXyzBelowGamutClipsToZero(): void
    {
        // Negative XYZ drives linear-sRGB negative on every channel → 0.
        $out = ColorConverter::toSrgb(new Color(-1.0, -1.0, -1.0, 1.0, ColorSpace::XYZD65));
        self::assertSrgb($out, 0.0, 0.0, 0.0, 0.0001);
    }

    public function testLchGamutMappedHugeChromaStaysInGamut(): void
    {
        // A chroma far outside sRGB must be binary-searched back in: the
        // result's channels stay within [0, 1] rather than clip-distorting.
        $out = ColorConverter::toSrgb(new Color(50.0, 200.0, 30.0, 1.0, ColorSpace::Lch));
        foreach ([$out->r, $out->g, $out->b] as $c) {
            self::assertGreaterThanOrEqual(0.0, $c);
            self::assertLessThanOrEqual(1.0, $c);
        }
    }

    public function testLchZeroLightnessIsBlackRegardlessOfChroma(): void
    {
        // L=0 short-circuits to black even with large chroma — clipping
        // would otherwise yield a dark non-black colour.
        self::assertSrgb(
            ColorConverter::toSrgb(new Color(0.0, 110.0, 60.0, 1.0, ColorSpace::Lch)),
            0.0,
            0.0,
            0.0,
            0.0001,
        );
    }

    public function testLchFullLightnessIsWhite(): void
    {
        self::assertSrgb(
            ColorConverter::toSrgb(new Color(100.0, 50.0, 200.0, 1.0, ColorSpace::Lch)),
            1.0,
            1.0,
            1.0,
            0.0001,
        );
    }

    public function testOklchLightnessExtremesShortCircuit(): void
    {
        // OKLCH lightness is 0–1, not 0–100.
        self::assertSrgb(ColorConverter::toSrgb(new Color(0.0, 0.4, 30.0, 1.0, ColorSpace::OKLCH)), 0.0, 0.0, 0.0, 0.0001);
        self::assertSrgb(ColorConverter::toSrgb(new Color(1.0, 0.4, 30.0, 1.0, ColorSpace::OKLCH)), 1.0, 1.0, 1.0, 0.0001);
    }

    public function testOklchNearExtremeLightnessCollapsesToBlackOrWhite(): void
    {
        // A lightness within a hair of the extremes (oklch(0.0001% …) /
        // oklch(99.9999% …)) is black / white regardless of chroma —
        // per-channel clipping would otherwise leave a saturated colour.
        self::assertSrgb(ColorConverter::toSrgb(new Color(0.000001, 0.2, 45.0, 1.0, ColorSpace::OKLCH)), 0.0, 0.0, 0.0, 0.0001);
        self::assertSrgb(ColorConverter::toSrgb(new Color(0.999999, 0.2, 45.0, 1.0, ColorSpace::OKLCH)), 1.0, 1.0, 1.0, 0.0001);
    }

    public function testOklchOutOfGamutClipsLikeDisplayP3(): void
    {
        // CSS Color 4 — an out-of-gamut wide-gamut colour clips per-channel
        // so lch/oklch converge with their lab/oklab/display-p3 siblings.
        // color(display-p3 0 1 0) ≈ oklch(0.8664 0.2947 142.5) clips to pure
        // green (#00ff00), matching the display-p3 conversion.
        $p3 = ColorConverter::toSrgb(new Color(0.0, 1.0, 0.0, 1.0, ColorSpace::DisplayP3));
        $oklch = ColorConverter::toSrgb(new Color(0.8664, 0.2947, 142.5, 1.0, ColorSpace::OKLCH));
        self::assertEqualsWithDelta($p3->r, $oklch->r, 0.02, 'oklch red matches display-p3 (clip)');
        self::assertEqualsWithDelta($p3->g, $oklch->g, 0.02, 'oklch green matches display-p3 (clip)');
        self::assertEqualsWithDelta($p3->b, $oklch->b, 0.02, 'oklch blue matches display-p3 (clip)');
    }

    public function testHwbWhitePlusBlackOverOneNormalisesToGray(): void
    {
        // w + b >= 1 collapses to gray = w / (w + b), ignoring hue.
        self::assertSrgb(ColorConverter::toSrgb(new Color(0.0, 0.5, 0.5, 1.0, ColorSpace::HWB)), 0.5, 0.5, 0.5, 0.0001);
        // 0.75 + 0.75 = 1.5 → gray 0.5 (hue still irrelevant).
        self::assertSrgb(ColorConverter::toSrgb(new Color(120.0, 0.75, 0.75, 1.0, ColorSpace::HWB)), 0.5, 0.5, 0.5, 0.0001);
    }

    public function testHwbHueWrapsModulo360(): void
    {
        $ref = ColorConverter::toSrgb(new Color(240.0, 0.0, 0.0, 1.0, ColorSpace::HWB));
        // -120 and 600 both alias to 240°.
        self::assertSrgb(ColorConverter::toSrgb(new Color(-120.0, 0.0, 0.0, 1.0, ColorSpace::HWB)), $ref->r, $ref->g, $ref->b, 0.0001);
        self::assertSrgb(ColorConverter::toSrgb(new Color(600.0, 0.0, 0.0, 1.0, ColorSpace::HWB)), $ref->r, $ref->g, $ref->b, 0.0001);
    }

    public function testAlphaPassesThroughEveryConversion(): void
    {
        $a = 0.375;
        $cases = [
            new Color(0.5, 0.5, 0.5, $a, ColorSpace::sRGBLinear),
            new Color(0.0, 0.2, 0.2, $a, ColorSpace::HWB),
            new Color(60.0, 20.0, -10.0, $a, ColorSpace::Lab),
            new Color(60.0, 30.0, 120.0, $a, ColorSpace::Lch),
            new Color(0.6, 0.0, 0.1, $a, ColorSpace::OKLab),
            new Color(0.6, 0.1, 120.0, $a, ColorSpace::OKLCH),
            new Color(...[...self::D65_WHITE, $a], space: ColorSpace::XYZD65),
            new Color(...[...self::D50_WHITE, $a], space: ColorSpace::XYZD50),
            new Color(0.5, 0.5, 0.5, $a, ColorSpace::DisplayP3),
            new Color(0.5, 0.5, 0.5, $a, ColorSpace::Rec2020),
            new Color(0.5, 0.5, 0.5, $a, ColorSpace::A98RGB),
            new Color(0.5, 0.5, 0.5, $a, ColorSpace::ProPhotoRGB),
        ];
        foreach ($cases as $c) {
            self::assertSame($a, ColorConverter::toSrgb($c)->a, $c->space->name);
        }
    }

    // ---- sRGB passthrough -------------------------------------------------

    public function testSrgbIsReturnedUnchanged(): void
    {
        $c = new Color(0.3, 0.6, 0.9, 0.8, ColorSpace::sRGB);
        self::assertSame($c, ColorConverter::toSrgb($c));
    }

    // ---- sRGB-linear gamma encoding --------------------------------------

    public function testLinearSrgbGammaEncodesMidAndThreshold(): void
    {
        // gamma(0.5) = 1.055 * 0.5^(1/2.4) - 0.055 ≈ 0.735357.
        self::assertSrgb(ColorConverter::toSrgb(new Color(0.5, 0.5, 0.5, 1.0, ColorSpace::sRGBLinear)), 0.735357, 0.735357, 0.735357, 0.0001);
        // At the piecewise threshold the linear segment applies: 12.92 * 0.0031308 ≈ 0.040450.
        self::assertSrgb(ColorConverter::toSrgb(new Color(0.0031308, 0.0031308, 0.0031308, 1.0, ColorSpace::sRGBLinear)), 0.040450, 0.040450, 0.040450, 0.0001);
    }

    // ---- HWB pure hues ----------------------------------------------------

    public function testHwbPureHues(): void
    {
        // w=b=0 → fully saturated hue-wheel colour.
        self::assertSrgb(ColorConverter::toSrgb(new Color(0.0, 0.0, 0.0, 1.0, ColorSpace::HWB)), 1.0, 0.0, 0.0, 0.0001);
        self::assertSrgb(ColorConverter::toSrgb(new Color(120.0, 0.0, 0.0, 1.0, ColorSpace::HWB)), 0.0, 1.0, 0.0, 0.0001);
        self::assertSrgb(ColorConverter::toSrgb(new Color(240.0, 0.0, 0.0, 1.0, ColorSpace::HWB)), 0.0, 0.0, 1.0, 0.0001);
    }

    // ---- Per-space white & black anchors ---------------------------------

    /**
     * @param array{0: float, 1: float, 2: float} $white
     * @param array{0: float, 1: float, 2: float} $black
     */
    #[DataProvider('whiteBlackProvider')]
    public function testWhiteAndBlackAnchors(ColorSpace $space, array $white, array $black): void
    {
        self::assertSrgb(ColorConverter::toSrgb(new Color($white[0], $white[1], $white[2], 1.0, $space)), 1.0, 1.0, 1.0);
        self::assertSrgb(ColorConverter::toSrgb(new Color($black[0], $black[1], $black[2], 1.0, $space)), 0.0, 0.0, 0.0);
    }

    /** @return iterable<string, array{ColorSpace, array{float,float,float}, array{float,float,float}}> */
    public static function whiteBlackProvider(): iterable
    {
        $one = [1.0, 1.0, 1.0];
        $zero = [0.0, 0.0, 0.0];
        yield 'sRGB-linear'     => [ColorSpace::sRGBLinear, $one, $zero];
        yield 'HWB'             => [ColorSpace::HWB, [0.0, 1.0, 0.0], [0.0, 0.0, 1.0]];
        yield 'Lab'             => [ColorSpace::Lab, [100.0, 0.0, 0.0], [0.0, 0.0, 0.0]];
        yield 'OKLab'           => [ColorSpace::OKLab, [1.0, 0.0, 0.0], [0.0, 0.0, 0.0]];
        yield 'XYZ'             => [ColorSpace::XYZ, self::D65_WHITE, $zero];
        yield 'XYZ-D65'         => [ColorSpace::XYZD65, self::D65_WHITE, $zero];
        yield 'XYZ-D50'         => [ColorSpace::XYZD50, self::D50_WHITE, $zero];
        yield 'Display-P3'      => [ColorSpace::DisplayP3, $one, $zero];
        yield 'Display-P3 lin'  => [ColorSpace::DisplayP3Linear, $one, $zero];
        yield 'A98RGB'          => [ColorSpace::A98RGB, $one, $zero];
        yield 'A98RGB lin'      => [ColorSpace::A98RGBLinear, $one, $zero];
        yield 'Rec2020'         => [ColorSpace::Rec2020, $one, $zero];
        yield 'Rec2020 lin'     => [ColorSpace::Rec2020Linear, $one, $zero];
        yield 'ProPhotoRGB'     => [ColorSpace::ProPhotoRGB, $one, $zero];
        yield 'ProPhotoRGB lin' => [ColorSpace::ProPhotoRGBLinear, $one, $zero];
    }

    // ---- Wide-gamut beyond sRGB ------------------------------------------

    public function testDisplayP3GreenIsMoreSaturatedThanSrgb(): void
    {
        // P3 green is outside sRGB; after conversion+clip the green channel
        // pins at 1 and the others stay low — a sanity check that the
        // degamma→matrix→XYZ→sRGB chain runs (not an identity).
        $out = ColorConverter::toSrgb(new Color(0.0, 1.0, 0.0, 1.0, ColorSpace::DisplayP3));
        self::assertEqualsWithDelta(1.0, $out->g, 0.01);
        self::assertLessThan(0.6, $out->r);
        self::assertLessThan(0.6, $out->b);
    }

    // ---- Color-space interpolation (CSS Color 4 §12) ---------------------

    /**
     * Endpoints are exact at t=0/t=1 for every supported space — the
     * forward matrices being exact inverses of the backward ones is what
     * guarantees the round-trip lands back on the authored colour.
     */
    #[DataProvider('interpolationSpaces')]
    public function testInterpolationEndpointsAreExact(ColorSpace $space): void
    {
        $red = new Color(1.0, 0.0, 0.0);
        $blue = new Color(0.0, 0.0, 1.0);
        $t0 = ColorConverter::interpolate($red, $blue, 0.0, $space, null);
        $t1 = ColorConverter::interpolate($red, $blue, 1.0, $space, null);
        self::assertEqualsWithDelta(1.0, $t0->r, 1e-3, $space->name . ' t0.r');
        self::assertEqualsWithDelta(0.0, $t0->b, 1e-3, $space->name . ' t0.b');
        self::assertEqualsWithDelta(0.0, $t1->r, 1e-3, $space->name . ' t1.r');
        self::assertEqualsWithDelta(1.0, $t1->b, 1e-3, $space->name . ' t1.b');
    }

    /** @return iterable<string, array{ColorSpace}> */
    public static function interpolationSpaces(): iterable
    {
        yield 'sRGB' => [ColorSpace::sRGB];
        yield 'sRGB-linear' => [ColorSpace::sRGBLinear];
        yield 'OKLab' => [ColorSpace::OKLab];
        yield 'OKLCH' => [ColorSpace::OKLCH];
        yield 'Lab' => [ColorSpace::Lab];
        yield 'LCH' => [ColorSpace::Lch];
        yield 'HSL' => [ColorSpace::HSL];
        yield 'HWB' => [ColorSpace::HWB];
        yield 'XYZ-D65' => [ColorSpace::XYZD65];
        yield 'Display-P3' => [ColorSpace::DisplayP3];
    }

    public function testOklchShorterAndLongerHueTakeOppositeArcs(): void
    {
        $red = new Color(1.0, 0.0, 0.0);
        $blue = new Color(0.0, 0.0, 1.0);
        // Shorter arc red→blue passes through magenta (high R and B).
        $short = ColorConverter::interpolate($red, $blue, 0.5, ColorSpace::OKLCH, HueInterpolation::Shorter);
        self::assertGreaterThan(0.5, $short->r);
        self::assertGreaterThan(0.5, $short->b);
        self::assertLessThan(0.2, $short->g);
        // Longer arc goes the other way, through green (high G, low R/B).
        $long = ColorConverter::interpolate($red, $blue, 0.5, ColorSpace::OKLCH, HueInterpolation::Longer);
        self::assertGreaterThan(0.4, $long->g);
        self::assertLessThan(0.2, $long->r);
    }

    public function testHslShorterMidpointIsMagenta(): void
    {
        // red hue 0°, blue hue 240°: the shorter arc runs 360°→240° (the
        // 120° way), whose midpoint 300° is magenta (1, 0, 1).
        $mid = ColorConverter::interpolate(
            new Color(1.0, 0.0, 0.0),
            new Color(0.0, 0.0, 1.0),
            0.5,
            ColorSpace::HSL,
            HueInterpolation::Shorter,
        );
        self::assertEqualsWithDelta(1.0, $mid->r, 1e-3);
        self::assertEqualsWithDelta(0.0, $mid->g, 1e-3);
        self::assertEqualsWithDelta(1.0, $mid->b, 1e-3);
    }

    public function testPowerlessHueAdoptsNeighbourHue(): void
    {
        // White is achromatic — its OKLCH hue is powerless and adopts
        // blue's, so white→blue interpolates lightness/chroma at a fixed
        // blue hue: the midpoint stays a blue (B the dominant channel),
        // never drifting toward a red/green off-hue.
        $mid = ColorConverter::interpolate(
            new Color(1.0, 1.0, 1.0),
            new Color(0.0, 0.0, 1.0),
            0.5,
            ColorSpace::OKLCH,
            HueInterpolation::Shorter,
        );
        self::assertGreaterThan($mid->r, $mid->b);
        self::assertGreaterThan($mid->g, $mid->b);
    }

    public function testUnsupportedSpaceFallsBackToSrgbInterpolation(): void
    {
        // A98-RGB has no forward conversion yet — interpolation must fall
        // back to plain sRGB (the previous behaviour), i.e. the midpoint of
        // red→blue is (0.5, 0, 0.5) as under DeviceRGB.
        $mid = ColorConverter::interpolate(
            new Color(1.0, 0.0, 0.0),
            new Color(0.0, 0.0, 1.0),
            0.5,
            ColorSpace::A98RGB,
            null,
        );
        self::assertEqualsWithDelta(0.5, $mid->r, 1e-6);
        self::assertEqualsWithDelta(0.0, $mid->g, 1e-6);
        self::assertEqualsWithDelta(0.5, $mid->b, 1e-6);
    }
}
