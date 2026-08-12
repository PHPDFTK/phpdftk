<?php

declare(strict_types=1);

namespace Phpdftk\Svg\Gradient;

/**
 * SVG `<linearGradient>` per SVG 2 §13.6. Endpoints `(x1, y1)` and
 * `(x2, y2)` define the gradient axis; stops are colour samples along it.
 *
 * Each endpoint accessor returns null when the attribute is absent so the
 * painter can apply the unit-mode-specific defaults (e.g., `x1=0` /
 * `x2=1` in `objectBoundingBox` mode, `0` / `100%` in `userSpaceOnUse`
 * mode per SVG 2 §13.6.5).
 */
final class LinearGradient extends Gradient
{
    public function __construct()
    {
        parent::__construct('linearGradient');
    }

    public function x1(): ?float
    {
        return $this->parseOptionalLength('x1');
    }

    public function y1(): ?float
    {
        return $this->parseOptionalLength('y1');
    }

    public function x2(): ?float
    {
        return $this->parseOptionalLength('x2');
    }

    public function y2(): ?float
    {
        return $this->parseOptionalLength('y2');
    }

    private function parseOptionalLength(string $attr): ?float
    {
        $raw = $this->getAttribute($attr);
        if ($raw === null) {
            return null;
        }
        if (preg_match('/^\s*([+-]?(?:\d+\.?\d*|\.\d+)(?:[eE][+-]?\d+)?)\s*(%?)/', $raw, $m) !== 1) {
            return null;
        }
        $value = (float) $m[1];
        // SVG 2 §13.6.5 — a percentage in objectBoundingBox mode (the default
        // gradientUnits) is a fraction of the bounding box, so `100%` == `1`.
        // Normalise to the [0, 1] fraction the GradientPainter bbox mapping
        // expects; parsing `x2="100%"` as `100` stretched the axis 100x so the
        // shape sampled a single stop (a solid colour).
        if ($m[2] === '%') {
            $value /= 100.0;
        }
        return $value;
    }
}
