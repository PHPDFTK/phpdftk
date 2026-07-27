<?php

declare(strict_types=1);

namespace Phpdftk\Css\Value;

/**
 * A `linear-gradient(to <corner>, …)` direction. Unlike side keywords
 * (`to top` / `to right`), a corner direction's angle depends on the
 * gradient box's aspect ratio: the gradient line is perpendicular to the
 * diagonal joining the two *other* corners (CSS Images 3 §3.1). So the
 * corner is preserved on the parsed value and resolved to a concrete
 * angle at paint time, when the box size is known.
 */
enum GradientCorner
{
    case TopLeft;
    case TopRight;
    case BottomLeft;
    case BottomRight;

    /**
     * The CSS gradient-line angle in degrees (0deg = to top, increasing
     * clockwise) that points this corner for a `$width` × `$height` box.
     *
     * The gradient line is perpendicular to the diagonal joining the other
     * two corners, so with `base = atan2(height, width)` (the top-right
     * angle) the four corners are `base`, `180 − base`, `180 + base`,
     * `360 − base`. A square (width == height) yields the familiar
     * 45 / 135 / 225 / 315.
     */
    public function angleFor(float $width, float $height): float
    {
        // Degenerate box → fall back to the square-diagonal angles.
        if ($width <= 0.0 || $height <= 0.0) {
            $base = 45.0;
        } else {
            $base = rad2deg(atan2($height, $width));
        }
        return match ($this) {
            self::TopRight => $base,
            self::BottomRight => 180.0 - $base,
            self::BottomLeft => 180.0 + $base,
            self::TopLeft => 360.0 - $base,
        };
    }

    /**
     * Map a set of side keywords (already lower-cased) to a corner, or
     * null when they don't name a corner (a single side or unrecognised).
     *
     * @param list<string> $sides
     */
    public static function fromSides(array $sides): ?self
    {
        $hasTop = in_array('top', $sides, true);
        $hasBottom = in_array('bottom', $sides, true);
        $hasLeft = in_array('left', $sides, true);
        $hasRight = in_array('right', $sides, true);
        return match (true) {
            $hasTop && $hasLeft => self::TopLeft,
            $hasTop && $hasRight => self::TopRight,
            $hasBottom && $hasLeft => self::BottomLeft,
            $hasBottom && $hasRight => self::BottomRight,
            default => null,
        };
    }
}
