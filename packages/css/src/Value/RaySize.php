<?php

declare(strict_types=1);

namespace Phpdftk\Css\Value;

/**
 * `<ray-size>` per CSS Motion Path 1 §2.2 — how long the ray is.
 *
 * All of these except {@see self::Sides} ignore the ray's angle: they
 * measure from the ray's origin to a side or corner of the containing
 * block. `sides` is the only one that follows the angle, stopping where
 * the ray crosses the containing block's boundary.
 */
enum RaySize: string
{
    case ClosestSide = 'closest-side';
    case ClosestCorner = 'closest-corner';
    case FarthestSide = 'farthest-side';
    case FarthestCorner = 'farthest-corner';
    case Sides = 'sides';
}
