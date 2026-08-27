<?php

declare(strict_types=1);

namespace Phpdftk\Css\Value;

/**
 * `ray()` per CSS Motion Path 1 §2.2 — a path defined by an angle and a
 * length rather than by geometry.
 *
 * Not a {@see BasicShape}: the spec makes `ray()` a separate
 * `<offset-path>` alternative, and it is never valid where a
 * `<basic-shape>` is expected (`clip-path`, `shape-outside`).
 *
 * The angle is a compass BEARING, not a mathematical angle: `0deg`
 * points up and positive angles turn clockwise.
 */
final readonly class Ray extends Value
{
    public function __construct(
        /** The ray's bearing. `Calc` when the author wrote `calc()`. */
        public Value $angle,
        public RaySize $size = RaySize::ClosestSide,
        /**
         * `contain` shortens the ray so the element stays inside its
         * containing block (CSS Motion Path 1 §2.2).
         */
        public bool $contain = false,
        /**
         * `at <position>` origin, as resolved x / y components. Null
         * means the origin comes from `offset-position` instead.
         */
        public ?Value $atX = null,
        public ?Value $atY = null,
    ) {}

    public function angleDegrees(): ?float
    {
        return $this->angle instanceof Angle ? $this->angle->toDegrees() : null;
    }

    public function toCss(): string
    {
        // Canonical order per the spec's serialization rules: angle,
        // then a non-default size, then `contain`, then `at <position>`.
        $parts = [$this->angle->toCss()];
        if ($this->size !== RaySize::ClosestSide) {
            $parts[] = $this->size->value;
        }
        if ($this->contain) {
            $parts[] = 'contain';
        }
        if ($this->atX !== null && $this->atY !== null) {
            $parts[] = 'at ' . $this->atX->toCss() . ' ' . $this->atY->toCss();
        }
        return 'ray(' . implode(' ', $parts) . ')';
    }
}
