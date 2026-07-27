<?php

declare(strict_types=1);

namespace Phpdftk\Css\Tests;

use Phpdftk\Css\Cascade\LengthContext;
use Phpdftk\Css\Cascade\LengthResolver;
use Phpdftk\Css\Value\Length;
use Phpdftk\Css\Value\LengthUnit;
use Phpdftk\Css\Value\Percentage;
use PHPUnit\Framework\TestCase;

final class LengthResolverTest extends TestCase
{
    public function testToPxConvertsAbsoluteUnitsAtCssCanonicalRatios(): void
    {
        $ctx = new LengthContext();
        self::assertEqualsWithDelta(16.0, LengthResolver::toPx(new Length(12.0, LengthUnit::Pt), $ctx), 0.001);
        self::assertEqualsWithDelta(96.0, LengthResolver::toPx(new Length(1.0, LengthUnit::In), $ctx), 0.001);
        self::assertEqualsWithDelta(16.0, LengthResolver::toPx(new Length(1.0, LengthUnit::Pc), $ctx), 0.001);
    }

    public function testCapUnitResolvesAgainstCapHeightRatio(): void
    {
        // CSS Values 4 §6.1.1 — `cap` is the cap-height of the element's
        // first available font. With a font's real metrics threaded in via
        // withFontMetrics, `1cap` = font-size × (capHeight / upem). Ahem's
        // cap-height is 0.8em, so `1cap` at 50px = 40px (not the 0.7 default).
        $ctx = (new LengthContext(currentFontSize: 50.0))->withFontMetrics(1.0, 1.0, 0.8);
        self::assertEqualsWithDelta(40.0, LengthResolver::toPx(new Length(1.0, LengthUnit::Cap), $ctx), 0.001);

        // Falls back to the 0.7em approximation when no font metrics are set.
        $bare = new LengthContext(currentFontSize: 100.0);
        self::assertEqualsWithDelta(70.0, LengthResolver::toPx(new Length(1.0, LengthUnit::Cap), $bare), 0.001);
    }

    public function testLhResolvesAgainstUsedLineHeight(): void
    {
        // CSS Values 4 §6.1.1 — `lh` is the element's used line-height.
        // With `line-height: 2` at `font-size: 50px`, the used line-height
        // is 100px, so `1lh` = 100px and `0.5lh` = 50px — NOT the
        // `1.2 × font-size` (60px) `normal` approximation.
        $ctx = (new LengthContext(currentFontSize: 50.0))->withLineHeight(100.0);
        self::assertEqualsWithDelta(100.0, LengthResolver::toPx(new Length(1.0, LengthUnit::Lh), $ctx), 0.001);
        self::assertEqualsWithDelta(50.0, LengthResolver::toPx(new Length(0.5, LengthUnit::Rlh), $ctx), 0.001);
    }

    public function testLhFallsBackToNormalApproximationWithoutLineHeight(): void
    {
        // When the context carries no resolved line-height (0 — `normal`
        // or not yet computed), `lh` falls back to `1.2 × font-size`.
        $ctx = new LengthContext(currentFontSize: 50.0);
        self::assertEqualsWithDelta(60.0, LengthResolver::toPx(new Length(1.0, LengthUnit::Lh), $ctx), 0.001);
    }

    public function testToPxClampsValuesAboveTheLayoutCeiling(): void
    {
        // Adversarial CSS: `padding: 2880804336vmax …` (one of the
        // WPT crashtest patterns). 2,880,804,336 × (1056 / 100) ≈
        // 3e10 px — multiple orders of magnitude above what layout
        // can meaningfully render. Clamp to MAX_PX so downstream
        // allocations sized to this dimension can't blow the heap.
        $ctx = new LengthContext();
        $clamped = LengthResolver::toPx(new Length(2880804336.0, LengthUnit::Vmax), $ctx);
        self::assertSame(LengthResolver::MAX_PX, $clamped);

        // Plain `px` past the ceiling also clamps.
        $bigPx = LengthResolver::toPx(new Length(12345678901234.0, LengthUnit::Px), $ctx);
        self::assertSame(LengthResolver::MAX_PX, $bigPx);

        // Symmetric on the negative side (negative margins, transforms).
        $negative = LengthResolver::toPx(new Length(-999999999999.0, LengthUnit::Px), $ctx);
        self::assertSame(-LengthResolver::MAX_PX, $negative);
    }

    public function testResolveValueClampsPercentageExpansion(): void
    {
        // 99_999_999% of a 1024-px container > 1e9 px. Clamp.
        $ctx = (new LengthContext())->withPercentageBasis(1024.0);
        $resolved = LengthResolver::resolveValue(new Percentage(99_999_999.0), $ctx);
        self::assertInstanceOf(Length::class, $resolved);
        self::assertSame(LengthResolver::MAX_PX, $resolved->value);
        self::assertSame(LengthUnit::Px, $resolved->unit);
    }

    public function testClampPxCollapsesNonFiniteInputs(): void
    {
        // NaN → 0 (the property's initial value per CSS Values 4 §6).
        self::assertSame(0.0, LengthResolver::clampPx(NAN));
        // ±Infinity → ±MAX_PX so layout math doesn't carry Inf.
        self::assertSame(LengthResolver::MAX_PX, LengthResolver::clampPx(INF));
        self::assertSame(-LengthResolver::MAX_PX, LengthResolver::clampPx(-INF));
    }

    public function testClampPxIsAPassthroughForInRangeValues(): void
    {
        self::assertSame(0.0, LengthResolver::clampPx(0.0));
        self::assertSame(42.5, LengthResolver::clampPx(42.5));
        self::assertSame(-1234.56, LengthResolver::clampPx(-1234.56));
        self::assertSame(LengthResolver::MAX_PX, LengthResolver::clampPx(LengthResolver::MAX_PX));
    }

    public function testContainerRelativeUnitsResolveAgainstNearestSizeContainer(): void
    {
        // CSS Containment 3 §6 — `cqw`/`cqi` use the container's
        // inline size, `cqh`/`cqb` the block size. Default ctx has
        // container sizes of 0 so cq* resolves to 0 (spec fallback).
        $ctx = (new LengthContext())->withContainerSize(400.0, 200.0);
        self::assertSame(200.0, LengthResolver::toPx(new Length(50.0, LengthUnit::Cqw), $ctx));
        self::assertSame(100.0, LengthResolver::toPx(new Length(50.0, LengthUnit::Cqh), $ctx));
        self::assertSame(200.0, LengthResolver::toPx(new Length(50.0, LengthUnit::Cqi), $ctx));
        self::assertSame(100.0, LengthResolver::toPx(new Length(50.0, LengthUnit::Cqb), $ctx));
        // cqmin = min(200, 400) / 100 * 50 = 100
        self::assertSame(100.0, LengthResolver::toPx(new Length(50.0, LengthUnit::Cqmin), $ctx));
        // cqmax = max(200, 400) / 100 * 50 = 200
        self::assertSame(200.0, LengthResolver::toPx(new Length(50.0, LengthUnit::Cqmax), $ctx));
    }

    public function testContainerRelativeUnitsCollapseToZeroOutsideAnyContainer(): void
    {
        // §6.3 — when no size container is in scope, cq* resolve to 0.
        $ctx = new LengthContext();
        self::assertSame(0.0, LengthResolver::toPx(new Length(100.0, LengthUnit::Cqw), $ctx));
        self::assertSame(0.0, LengthResolver::toPx(new Length(100.0, LengthUnit::Cqh), $ctx));
        self::assertSame(0.0, LengthResolver::toPx(new Length(100.0, LengthUnit::Cqmin), $ctx));
    }
}
