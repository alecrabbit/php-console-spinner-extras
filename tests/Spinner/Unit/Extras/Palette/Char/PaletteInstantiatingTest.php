<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Palette\Char;

use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class PaletteInstantiatingTest extends TestCase
{
    public static function paletteClassesProvider(): iterable
    {
        yield from [
            [\AlecRabbit\Spinner\Extras\Palette\Char\Aesthetic::class,],  // #00
            [\AlecRabbit\Spinner\Extras\Palette\Char\Ascii::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\ChristmasTree::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\Clock::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\ClockHourly::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\Diamond::class,],  // #05
            [\AlecRabbit\Spinner\Extras\Palette\Char\Dice::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\Dot::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\DotBinaryCount::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\Earth::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\FeatheredArrow::class,], // #10
            [\AlecRabbit\Spinner\Extras\Palette\Char\FingerDance::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\FistBump::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\HalfCircle::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\MindBlown::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\Monkey::class,],// #15
            [\AlecRabbit\Spinner\Extras\Palette\Char\Moon::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\PulseBlue::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\PulseOrange::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\PulseOrangeBlue::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\RainyWeather::class,], // #20
            [\AlecRabbit\Spinner\Extras\Palette\Char\Runner::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\Sector::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\ShortSnake::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\Speaker::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\Square::class,], // #25
            [\AlecRabbit\Spinner\Extras\Palette\Char\SquareToggle::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\StormyWeather::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\SwirlingDots::class,],
            [\AlecRabbit\Spinner\Extras\Palette\Char\Toggle::class,], // #29
        ];
    }

    #[Test]
    #[DataProvider('paletteClassesProvider')]
    public function canBeInstantiated(string $class): void
    {
        $palette = new $class();

        self::assertInstanceOf($class, $palette);
    }
}
