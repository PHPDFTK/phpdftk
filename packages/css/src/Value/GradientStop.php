<?php

declare(strict_types=1);

namespace Phpdftk\Css\Value;

/**
 * One stop in a gradient: a colour plus an optional position. When the
 * position is null the renderer interpolates based on neighbour stops.
 *
 * A position may also be a {@see Calc} — e.g. `calc(2em)` — which carries
 * font-/container-relative units the cascade resolves to an absolute
 * {@see Length} before paint. Percentages stay as authored (resolved
 * against the gradient line at paint time).
 */
final readonly class GradientStop
{
    public function __construct(public Color $color, public Length|Percentage|Calc|null $position) {}

    public function toCss(): string
    {
        $out = $this->color->toCss();
        if ($this->position !== null) {
            $out .= ' ' . $this->position->toCss();
        }
        return $out;
    }
}
