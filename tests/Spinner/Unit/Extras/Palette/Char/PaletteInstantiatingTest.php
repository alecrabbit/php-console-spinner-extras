<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Palette\Char;

use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Spinner\Extras\Palette\Char;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class PaletteInstantiatingTest extends TestCase
{
    public static function paletteClassesProvider(): iterable
    {
        yield from [
            [Char\Aesthetic::class,],  // #00
            [Char\Ascii::class,],
            [Char\ChristmasTree::class,],
            [Char\Clock::class,],
            [Char\ClockHourly::class,],
            [Char\Diamond::class,],  // #05
            [Char\Dice::class,],
            [Char\Dot::class,],
            [Char\DotBinaryCount::class,],
            [Char\Earth::class,],
            [Char\FeatheredArrow::class,], // #10
            [Char\FingerDance::class,],
            [Char\FistBump::class,],
            [Char\HalfCircle::class,],
            [Char\MindBlown::class,],
            [Char\Monkey::class,],// #15
            [Char\Moon::class,],
            [Char\PulseBlue::class,],
            [Char\PulseOrange::class,],
            [Char\PulseOrangeBlue::class,],
            [Char\RainyWeather::class,], // #20
            [Char\Runner::class,],
            [Char\Sector::class,],
            [Char\ShortSnake::class,],
            [Char\Speaker::class,],
            [Char\Square::class,], // #25
            [Char\SquareToggle::class,],
            [Char\StormyWeather::class,],
            [Char\SwirlingDots::class,],
            [Char\Toggle::class,], // #29
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
