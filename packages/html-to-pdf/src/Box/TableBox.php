<?php

declare(strict_types=1);

namespace Phpdftk\HtmlToPdf\Box;

/**
 * `display: table` — block-level wrapper around row groups / rows / cells.
 * Phase-1 layout treats it as a block that hosts one or more
 * {@see TableRowBox}es; CSS Tables 3 §3 automatic column-width / table-
 * caption / multi-section layout lands in a follow-up.
 */
final class TableBox extends Box
{
    /**
     * CSS 2.1 §17.5.1 background layers 2 (column groups) and 3
     * (columns), in paint order, each with the column range it covers.
     * `<col>` / `<colgroup>` generate no boxes of their own, so the
     * painter needs this to know which cells each one's background
     * reaches.
     *
     * @var list<array{box: TableColumnBox, start: int, span: int}>
     */
    public array $columnLayers = [];
}
