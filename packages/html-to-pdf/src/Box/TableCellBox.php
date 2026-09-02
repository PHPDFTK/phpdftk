<?php

declare(strict_types=1);

namespace Phpdftk\HtmlToPdf\Box;

/**
 * `display: table-cell`. Behaves like a block box but its width / x
 * position are set by the parent {@see TableRowBox} during layout.
 */
final class TableCellBox extends Box
{
    /**
     * Zero-based index of the column this cell starts in, and how many
     * columns it spans. Recorded during layout from the table's cell
     * grid so the painter can resolve the CSS 2.1 §17.5.1 column
     * background layers without rebuilding the grid.
     */
    public ?int $tableColumn = null;

    public int $tableColumnSpan = 1;
}
