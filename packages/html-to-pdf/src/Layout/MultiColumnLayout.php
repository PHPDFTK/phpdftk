<?php

declare(strict_types=1);

namespace Phpdftk\HtmlToPdf\Layout;

use Phpdftk\Css\Value\Color;

/**
 * Resolved multi-column container layout — populated by
 * {@see BlockLayout::layoutMultiColumn()} when a box's cascade declares
 * `column-count` and/or `column-width` non-`auto`.
 *
 * The painter reads this to draw `column-rule` strokes between adjacent
 * columns (CSS Multi-column 1 §3). The geometry is recorded relative to
 * the container's content edge: column 0 starts at `box.geometry.x`, each
 * subsequent column at `x + i * (columnWidth + columnGap)`.
 */
final readonly class MultiColumnLayout
{
    public function __construct(
        public int $columnCount,
        public float $columnWidth,
        public float $columnGap,
        public float $ruleWidth,
        public string $ruleStyle,
        public ?Color $ruleColor,
        /**
         * CSS Multi-column 1 §3.3 — `column-fill: auto` fragmentation. When
         * true the container's content was laid out in a SINGLE tall column
         * (children keep their column-0 positions) and the painter must
         * SLICE it into `columnCount` bands of `columnHeight`, translating
         * band `i` to column `i`. `contentTop` is the layout-Y of the top of
         * the tall column (band 0's origin). False (the default) = the
         * classic balance path, where children were already moved to their
         * columns and paint once.
         */
        public bool $fragmented = false,
        public float $columnHeight = 0.0,
        public float $contentTop = 0.0,
        /**
         * CSS Multi-column 2 §3 — `column-wrap: wrap`. When true the tall
         * content is sliced into bands of `columnHeight` and wrapped into a
         * `columnCount × rowCount` grid (filling a row of columns left→right,
         * then the next row down), rather than a single row of `columnCount`
         * columns. `contentHeight` is the tall content's total block size (to
         * derive the band/row count); `rowGap` separates the rows.
         */
        public bool $columnWrap = false,
        public float $contentHeight = 0.0,
        public float $rowGap = 0.0,
    ) {}
}
