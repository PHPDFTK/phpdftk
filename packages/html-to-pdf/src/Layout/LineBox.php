<?php

declare(strict_types=1);

namespace Phpdftk\HtmlToPdf\Layout;

/**
 * One laid-out line inside an inline formatting context.
 *
 * `y` is the line's top edge in the parent block's coordinate space;
 * `height` is the line's allocated vertical space. `baseline` is the
 * distance from the line's top edge down to the line's single shared
 * baseline (CSS2 §10.8): every baseline-aligned fragment places its own
 * baseline here, so mixed-size runs line up. `fragments` are placed
 * left-to-right in logical order; bidi visual reorder happens before
 * this stage.
 */
final class LineBox
{
    /** @param list<InlineFragment> $fragments */
    public function __construct(
        public float $y,
        public float $height,
        public array $fragments,
        public float $baseline = 0.0,
    ) {}

    public function totalWidth(): float
    {
        $right = 0.0;
        foreach ($this->fragments as $f) {
            $right = max($right, $f->x + $f->width);
        }
        return $right;
    }
}
