<?php

declare(strict_types=1);

namespace Phpdftk\HtmlToPdf\Layout;

/**
 * One active float inside a {@see FloatContext}. Stored as a value
 * object so {@see FloatContext} stays free of mutation accidents.
 */
final readonly class FloatItem
{
    /**
     * @param array<string, mixed>|null $shape CSS Shapes 1 §3 exclusion
     *        shape (a kind-keyed dict: `circle` / `ellipse` / `polygon`
     *        / `path`), or null for the float's bounding rectangle.
     */
    public function __construct(
        /** `'left'` or `'right'` per CSS 2.1 §9.5. */
        public string $side,
        public float $left,
        public float $top,
        public float $width,
        public float $height,
        /**
         * CSS Shapes 1 §3 — when set, describes a per-Y exclusion
         * shape carved out of the float's box. The default `null`
         * means "axis-aligned rectangle of width × height" (the
         * pre-shapes behaviour). When non-null, `FloatContext`'s
         * leftEdgeAt / rightEdgeAt evaluate the shape at the line's
         * Y instead of using the bounding rect.
         *
         * `kind: 'circle'` carries center coordinates `(cx, cy)`
         * relative to the FloatItem's top-left, plus radius `r`.
         */
        public ?array $shape = null,
        /**
         * CSS 2.1 §9.5.1 / §9.5.2 — the float's MARGIN box. Float-vs-
         * float placement and `clear` settle against this, never
         * against the (possibly contracted) exclusion rect above: a
         * `shape-outside: content-box` float still occupies its full
         * margin box as far as other floats are concerned.
         *
         * Null means "same as the exclusion rect", which is the case
         * whenever `shape-outside` is absent — the overwhelming
         * default, and byte-identical to the pre-shapes behaviour.
         */
        public ?float $marginLeft = null,
        public ?float $marginTop = null,
        public ?float $marginWidth = null,
        public ?float $marginHeight = null,
    ) {}

    /** Margin-box left edge, falling back to the exclusion rect. */
    public function marginBoxLeft(): float
    {
        return $this->marginLeft ?? $this->left;
    }

    /** Margin-box top edge, falling back to the exclusion rect. */
    public function marginBoxTop(): float
    {
        return $this->marginTop ?? $this->top;
    }

    /** Margin-box width, falling back to the exclusion rect. */
    public function marginBoxWidth(): float
    {
        return $this->marginWidth ?? $this->width;
    }

    /** Margin-box height, falling back to the exclusion rect. */
    public function marginBoxHeight(): float
    {
        return $this->marginHeight ?? $this->height;
    }
}
