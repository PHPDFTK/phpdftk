<?php

declare(strict_types=1);

namespace Phpdftk\Css\Value;

/**
 * CSS Color 5 §3 — `color-mix(in <space>, c1 [p1%], c2 [p2%])`.
 *
 * Stored as the parsed declaration; the actual mixing math runs
 * when the 4E color engine ships. Percentages are normalised at
 * parse time per §3.1:
 *
 *   - If neither percentage is supplied, both default to 50%.
 *   - If one is supplied, the other is 100% − that value.
 *   - If both sum to > 0% but ≠ 100%, multiply by 100/(p1+p2) to
 *     normalise and remember the original sum as `alphaMultiplier`
 *     so the resulting alpha can be scaled.
 *   - If both sum to 0%, the result is invalid; the parser
 *     returns null in that case.
 *
 * `hueInterpolation` is non-null only when `space` is a polar
 * space (HSL, HWB, LCH, OKLCH); for other spaces the field is
 * meaningless and stays null.
 */
final readonly class ColorMix extends Value
{
    public function __construct(
        public ColorSpace $space,
        public Color $color1,
        public float $percentage1,
        public Color $color2,
        public float $percentage2,
        public float $alphaMultiplier = 1.0,
        public ?HueInterpolation $hueInterpolation = null,
    ) {}

    public function toCss(): string
    {
        $hueSuffix = $this->hueInterpolation !== null
            ? ' ' . $this->hueInterpolation->value . ' hue'
            : '';
        $space = match ($this->space) {
            ColorSpace::sRGB => 'srgb',
            ColorSpace::sRGBLinear => 'srgb-linear',
            ColorSpace::DisplayP3 => 'display-p3',
            ColorSpace::DisplayP3Linear => 'display-p3-linear',
            ColorSpace::A98RGB => 'a98-rgb',
            ColorSpace::A98RGBLinear => 'a98-rgb-linear',
            ColorSpace::ProPhotoRGB => 'prophoto-rgb',
            ColorSpace::ProPhotoRGBLinear => 'prophoto-rgb-linear',
            ColorSpace::Rec2020 => 'rec2020',
            ColorSpace::Rec2020Linear => 'rec2020-linear',
            ColorSpace::Lab => 'lab',
            ColorSpace::Lch => 'lch',
            ColorSpace::OKLab => 'oklab',
            ColorSpace::OKLCH => 'oklch',
            ColorSpace::XYZ, ColorSpace::XYZD65 => 'xyz-d65',
            ColorSpace::XYZD50 => 'xyz-d50',
            ColorSpace::HWB => 'hwb',
            ColorSpace::HSL => 'hsl',
        };
        return sprintf(
            'color-mix(in %s%s, %s %s%%, %s %s%%)',
            $space,
            $hueSuffix,
            $this->color1->toCss(),
            self::trim($this->percentage1),
            $this->color2->toCss(),
            self::trim($this->percentage2),
        );
    }

    /**
     * CSS Color 5 §3 — resolve the mix to a concrete sRGB {@see Color} by
     * interpolating the two colours in `$space` (with the hue direction for
     * polar spaces) at the fraction implied by the normalised percentages,
     * then scaling the result alpha by `$alphaMultiplier` (non-100 %-sum
     * mixes make the result partly transparent). Both colours are always
     * concrete — the parser rejects unresolvable arguments to a plain
     * {@see \Phpdftk\Css\Value\CssFunction} — so this never fails.
     */
    public function evaluate(): Color
    {
        $total = $this->percentage1 + $this->percentage2;
        if ($total <= 0.0) {
            // Degenerate (both 0 %); the parser normally rejects this, but
            // fall back to transparent rather than dividing by zero.
            return new Color(0.0, 0.0, 0.0, 0.0);
        }
        $t = $this->percentage2 / $total;
        $mixed = ColorConverter::interpolate($this->color1, $this->color2, $t, $this->space, $this->hueInterpolation);
        $alpha = max(0.0, min(1.0, $mixed->a * $this->alphaMultiplier));
        return new Color($mixed->r, $mixed->g, $mixed->b, $alpha);
    }

    private static function trim(float $v): string
    {
        return fmod($v, 1.0) === 0.0 ? (string) (int) $v : (string) $v;
    }
}
