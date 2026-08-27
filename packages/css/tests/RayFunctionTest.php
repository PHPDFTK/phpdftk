<?php

declare(strict_types=1);

namespace Phpdftk\Css\Tests;

use Phpdftk\Css\Value\Calc;
use Phpdftk\Css\Value\CssFunction;
use Phpdftk\Css\Value\Length;
use Phpdftk\Css\Value\Ray;
use Phpdftk\Css\Value\RaySize;
use Phpdftk\Css\ValueParser;
use PHPUnit\Framework\TestCase;

/**
 * CSS Motion Path 1 §2.2 `ray()` parsing.
 *
 * `ray()` is an `<offset-path>` alternative in its own right, not a
 * `<basic-shape>`, so it must never appear where a shape is expected.
 */
final class RayFunctionTest extends TestCase
{
    private ValueParser $parser;

    protected function setUp(): void
    {
        $this->parser = new ValueParser();
    }

    public function testParsesBareAngle(): void
    {
        $ray = $this->parser->parseFromString('ray(45deg)');
        self::assertInstanceOf(Ray::class, $ray);
        self::assertSame(45.0, $ray->angleDegrees());
        // Omitted size defaults to closest-side.
        self::assertSame(RaySize::ClosestSide, $ray->size);
        self::assertFalse($ray->contain);
        self::assertNull($ray->atX);
    }

    public function testParsesEverySizeKeyword(): void
    {
        foreach (RaySize::cases() as $size) {
            $ray = $this->parser->parseFromString('ray(0deg ' . $size->value . ')');
            self::assertInstanceOf(Ray::class, $ray, $size->value);
            self::assertSame($size, $ray->size);
        }
    }

    public function testParsesNonDegreeAngleUnits(): void
    {
        $ray = $this->parser->parseFromString('ray(200grad farthest-side)');
        self::assertInstanceOf(Ray::class, $ray);
        self::assertEqualsWithDelta(180.0, $ray->angleDegrees(), 0.0001);
    }

    public function testParsesContainAndPosition(): void
    {
        $ray = $this->parser->parseFromString('ray(270deg farthest-corner contain)');
        self::assertInstanceOf(Ray::class, $ray);
        self::assertSame(RaySize::FarthestCorner, $ray->size);
        self::assertTrue($ray->contain);

        $at = $this->parser->parseFromString('ray(0deg at 100px 100px)');
        self::assertInstanceOf(Ray::class, $at);
        self::assertInstanceOf(Length::class, $at->atX);
        self::assertSame(100.0, $at->atX->value);
    }

    /**
     * The grammar joins the components with `&&`, so they may be written
     * in ANY order — and `at <position>` may be followed by more of the
     * ray rather than ending it.
     */
    public function testComponentsMayAppearInAnyOrder(): void
    {
        $ray = $this->parser->parseFromString('ray(at 10px 10px 0deg contain)');
        self::assertInstanceOf(Ray::class, $ray);
        self::assertSame(0.0, $ray->angleDegrees());
        self::assertTrue($ray->contain);
        self::assertInstanceOf(Length::class, $ray->atX);
        self::assertSame(10.0, $ray->atX->value);
        // Serialization is canonical regardless of authored order.
        self::assertSame('ray(0deg contain at 10px 10px)', $ray->toCss());
    }

    public function testSerializesCanonically(): void
    {
        self::assertSame(
            'ray(0deg sides at 50% 50%)',
            (string) $this->parser->parseFromString('ray(0deg sides at center center)')?->toCss(),
        );
        // A default size is omitted from the serialization.
        self::assertSame(
            'ray(45deg)',
            (string) $this->parser->parseFromString('ray(45deg closest-side)')?->toCss(),
        );
    }

    public function testAcceptsCalcAngle(): void
    {
        $ray = $this->parser->parseFromString('ray(calc(180deg - 45deg) farthest-side)');
        self::assertInstanceOf(Ray::class, $ray);
        self::assertInstanceOf(Calc::class, $ray->angle);
    }

    /**
     * An angle is required, and each component may appear only once.
     * Invalid rays fall through to a generic function rather than
     * producing a half-built path.
     */
    public function testRejectsInvalidForms(): void
    {
        foreach ([
            'ray(closest-side)',        // no angle
            'ray(45deg 90deg)',         // two angles
            'ray(0deg sides sides)',    // duplicate size
            'ray(0deg contain contain)', // duplicate contain
            'ray(0deg at)',             // `at` with no position
        ] as $source) {
            self::assertNotInstanceOf(
                Ray::class,
                $this->parser->parseFromString($source),
                $source,
            );
        }
    }

    public function testRayIsNotABasicShape(): void
    {
        // `clip-path: ray(...)` is invalid; it must not parse as a shape.
        $ray = $this->parser->parseFromString('ray(45deg)');
        self::assertInstanceOf(Ray::class, $ray);
        self::assertNotInstanceOf(CssFunction::class, $ray);
    }
}
