<?php

declare(strict_types=1);

namespace Phpdftk\Svg;

/**
 * A nested `<svg>` element (an `<svg>` that is not the document root).
 *
 * SVG 2 §7.5 — a nested `<svg>` establishes a new viewport (from its
 * `x` / `y` / `width` / `height`) and, when it carries a `viewBox`, a new
 * user coordinate system for its children (with the viewBox-to-viewport
 * scale + `preserveAspectRatio` alignment). Overflow is clipped to the
 * viewport by default. The root `<svg>` is {@see SvgDocument}; both share
 * the viewBox machinery in {@see ViewportElement}.
 */
final class NestedSvg extends ViewportElement
{
    public function __construct()
    {
        parent::__construct('svg');
    }
}
