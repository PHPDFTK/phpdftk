<?php

declare(strict_types=1);

namespace Phpdftk\Css\Tests;

use Phpdftk\Css\Value\Color;
use Phpdftk\Css\Value\ColorMix;
use Phpdftk\Css\Value\ColorSpace;
use Phpdftk\Css\Value\CssFunction;
use Phpdftk\Css\Value\HueInterpolation;
use Phpdftk\Css\ValueParser;
use PHPUnit\Framework\TestCase;

/**
 * CSS Color 5 §3 — `color-mix(in <space>, c1 [%], c2 [%])` parsing +
 * evaluation. Tests cover the percentage-normalisation rules, polar vs
 * rectangular spaces, hue interpolation methods, graceful fallback on
 * malformed input, and {@see ColorMix::evaluate()} resolving to a concrete
 * sRGB colour via the shared interpolation engine.
 */
final class ColorMixTest extends TestCase
{
    private ValueParser $parser;

    protected function setUp(): void
    {
        $this->parser = new ValueParser();
    }

    private function parseMix(string $css): ColorMix
    {
        $value = $this->parser->parseFromString($css);
        self::assertInstanceOf(ColorMix::class, $value, "expected ColorMix, got " . get_debug_type($value));
        return $value;
    }

    // -----------------------------------------------------------------------
    // Basic parsing
    // -----------------------------------------------------------------------

    public function testTwoColorsDefaultsToFiftyFifty(): void
    {
        $mix = $this->parseMix('color-mix(in oklab, #ff0000, #0000ff)');
        self::assertSame(ColorSpace::OKLab, $mix->space);
        self::assertSame(50.0, $mix->percentage1);
        self::assertSame(50.0, $mix->percentage2);
        self::assertSame(1.0, $mix->alphaMultiplier);
        self::assertNull($mix->hueInterpolation);
        self::assertInstanceOf(Color::class, $mix->color1);
        self::assertInstanceOf(Color::class, $mix->color2);
    }

    public function testFirstPercentageOnlyDerivesSecond(): void
    {
        $mix = $this->parseMix('color-mix(in oklab, #ff0000 30%, #0000ff)');
        self::assertSame(30.0, $mix->percentage1);
        self::assertSame(70.0, $mix->percentage2);
    }

    public function testSecondPercentageOnlyDerivesFirst(): void
    {
        $mix = $this->parseMix('color-mix(in oklab, #ff0000, #0000ff 80%)');
        self::assertSame(20.0, $mix->percentage1);
        self::assertSame(80.0, $mix->percentage2);
    }

    public function testBothPercentagesSummingToOneHundred(): void
    {
        $mix = $this->parseMix('color-mix(in oklab, #ff0000 40%, #0000ff 60%)');
        self::assertSame(40.0, $mix->percentage1);
        self::assertSame(60.0, $mix->percentage2);
        self::assertSame(1.0, $mix->alphaMultiplier);
    }

    public function testBothPercentagesSummingToLessThanOneHundredNormalise(): void
    {
        // 25% + 25% = 50% total → scale to 50/50; alphaMultiplier = 0.5
        $mix = $this->parseMix('color-mix(in oklab, #ff0000 25%, #0000ff 25%)');
        self::assertEqualsWithDelta(50.0, $mix->percentage1, 1e-9);
        self::assertEqualsWithDelta(50.0, $mix->percentage2, 1e-9);
        self::assertEqualsWithDelta(0.5, $mix->alphaMultiplier, 1e-9);
    }

    public function testBothPercentagesSummingToMoreThanOneHundredNormalise(): void
    {
        // 60 + 60 = 120 → scale 60/60 to 50/50; alphaMultiplier
        // capped at 1.0 (we don't amplify alpha above opaque).
        $mix = $this->parseMix('color-mix(in oklab, #ff0000 60%, #0000ff 60%)');
        self::assertEqualsWithDelta(50.0, $mix->percentage1, 1e-9);
        self::assertEqualsWithDelta(50.0, $mix->percentage2, 1e-9);
        self::assertSame(1.0, $mix->alphaMultiplier);
    }

    public function testBothZeroIsInvalid(): void
    {
        $value = $this->parser->parseFromString('color-mix(in oklab, #ff0000 0%, #0000ff 0%)');
        // 0 + 0 sum is invalid per §3.1 → falls through to CssFunction.
        self::assertNotInstanceOf(ColorMix::class, $value);
        self::assertInstanceOf(CssFunction::class, $value);
    }

    // -----------------------------------------------------------------------
    // Color spaces
    // -----------------------------------------------------------------------

    public function testSrgbSpace(): void
    {
        $mix = $this->parseMix('color-mix(in srgb, red, blue)');
        self::assertSame(ColorSpace::sRGB, $mix->space);
    }

    public function testDisplayP3Space(): void
    {
        $mix = $this->parseMix('color-mix(in display-p3, #ff0000, #00ff00)');
        self::assertSame(ColorSpace::DisplayP3, $mix->space);
    }

    public function testLchSpace(): void
    {
        $mix = $this->parseMix('color-mix(in lch, #ff0000, #00ff00)');
        self::assertSame(ColorSpace::Lch, $mix->space);
    }

    public function testHslKeepsPolarSpace(): void
    {
        // HSL is a polar space — it keeps a distinct space tag so the
        // interpolation engine can travel the hue channel (CSS Color 4
        // §12.4), rather than collapsing onto sRGB.
        $mix = $this->parseMix('color-mix(in hsl, #ff0000, #00ff00)');
        self::assertSame(ColorSpace::HSL, $mix->space);
    }

    public function testHwbKeepsPolarSpace(): void
    {
        $mix = $this->parseMix('color-mix(in hwb, #ff0000, #00ff00)');
        self::assertSame(ColorSpace::HWB, $mix->space);
    }

    public function testXyzAliasMapsToD65(): void
    {
        $mix = $this->parseMix('color-mix(in xyz, #ff0000, #00ff00)');
        self::assertSame(ColorSpace::XYZD65, $mix->space);
    }

    // -----------------------------------------------------------------------
    // Hue interpolation
    // -----------------------------------------------------------------------

    public function testShorterHueInterpolation(): void
    {
        $mix = $this->parseMix('color-mix(in oklch shorter hue, #ff0000, #00ff00)');
        self::assertSame(HueInterpolation::Shorter, $mix->hueInterpolation);
    }

    public function testLongerHueInterpolation(): void
    {
        $mix = $this->parseMix('color-mix(in oklch longer hue, #ff0000, #00ff00)');
        self::assertSame(HueInterpolation::Longer, $mix->hueInterpolation);
    }

    public function testIncreasingHueInterpolation(): void
    {
        $mix = $this->parseMix('color-mix(in lch increasing hue, #ff0000, #00ff00)');
        self::assertSame(HueInterpolation::Increasing, $mix->hueInterpolation);
    }

    public function testDecreasingHueInterpolation(): void
    {
        $mix = $this->parseMix('color-mix(in lch decreasing hue, #ff0000, #00ff00)');
        self::assertSame(HueInterpolation::Decreasing, $mix->hueInterpolation);
    }

    public function testMissingHueKeywordIsInvalid(): void
    {
        // "shorter" without "hue" should be malformed.
        $value = $this->parser->parseFromString('color-mix(in lch shorter, #ff0000, #00ff00)');
        self::assertInstanceOf(CssFunction::class, $value);
    }

    // -----------------------------------------------------------------------
    // Malformed input
    // -----------------------------------------------------------------------

    public function testMissingInKeywordIsInvalid(): void
    {
        $value = $this->parser->parseFromString('color-mix(oklab, red, blue)');
        self::assertInstanceOf(CssFunction::class, $value);
    }

    public function testUnknownSpaceIsInvalid(): void
    {
        $value = $this->parser->parseFromString('color-mix(in fakespace, red, blue)');
        self::assertInstanceOf(CssFunction::class, $value);
    }

    public function testTooFewArgumentsIsInvalid(): void
    {
        $value = $this->parser->parseFromString('color-mix(in oklab, red)');
        self::assertInstanceOf(CssFunction::class, $value);
    }

    public function testTooManyArgumentsIsInvalid(): void
    {
        $value = $this->parser->parseFromString('color-mix(in oklab, red, blue, green)');
        self::assertInstanceOf(CssFunction::class, $value);
    }

    // -----------------------------------------------------------------------
    // Nested color functions
    // -----------------------------------------------------------------------

    public function testMixOfLabAndOklch(): void
    {
        $mix = $this->parseMix('color-mix(in oklab, lab(50 20 -30), oklch(0.6 0.2 240))');
        self::assertSame(ColorSpace::Lab, $mix->color1->space);
        self::assertSame(ColorSpace::OKLCH, $mix->color2->space);
    }

    // -----------------------------------------------------------------------
    // evaluate() — resolve to a concrete sRGB colour
    // -----------------------------------------------------------------------

    public function testEvaluateSrgbMidpoint(): void
    {
        // sRGB mix of red + blue is the linear midpoint (0.5, 0, 0.5).
        $out = $this->parseMix('color-mix(in srgb, red, blue)')->evaluate();
        self::assertEqualsWithDelta(0.5, $out->r, 1e-6);
        self::assertEqualsWithDelta(0.0, $out->g, 1e-6);
        self::assertEqualsWithDelta(0.5, $out->b, 1e-6);
        self::assertEqualsWithDelta(1.0, $out->a, 1e-6);
    }

    public function testEvaluateWeightedPercentageShiftsTowardSecondColor(): void
    {
        // `red 30%` → 70 % blue, so the result sits 0.7 of the way to blue.
        $out = $this->parseMix('color-mix(in srgb, red 30%, blue)')->evaluate();
        self::assertEqualsWithDelta(0.3, $out->r, 1e-6);
        self::assertEqualsWithDelta(0.7, $out->b, 1e-6);
    }

    public function testEvaluateSubHundredPercentSumScalesAlpha(): void
    {
        // 25 % + 25 % sums to 50 %: colours normalise to 50/50 but the
        // result alpha is scaled by 0.5 (CSS Color 5 §3.1).
        $out = $this->parseMix('color-mix(in srgb, red 25%, blue 25%)')->evaluate();
        self::assertEqualsWithDelta(0.5, $out->a, 1e-6);
    }

    public function testEvaluateLchLongerHuePassesThroughGreen(): void
    {
        // The longer-hue arc red→blue in LCH passes through green, so the
        // 50 % mix has a dominant green channel (this is exactly the middle
        // stop WPT's gradient-longer-hue-lch reference builds).
        $out = $this->parseMix('color-mix(in lch longer hue, red, blue)')->evaluate();
        self::assertGreaterThan($out->r, $out->g);
        self::assertGreaterThan($out->b, $out->g);
    }

    public function testEvaluateOklchIsConcreteSrgbColor(): void
    {
        // Non-sRGB spaces now resolve (previously passed through unmixed);
        // the result is a concrete in-gamut sRGB colour.
        $out = $this->parseMix('color-mix(in oklch, red, blue)')->evaluate();
        self::assertInstanceOf(Color::class, $out);
        self::assertGreaterThanOrEqual(0.0, $out->r);
        self::assertLessThanOrEqual(1.0, $out->r);
        self::assertSame(ColorSpace::sRGB, $out->space);
    }
}
