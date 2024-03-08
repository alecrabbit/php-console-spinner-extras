<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Extras\Palette\Char;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class PaletteInstantiatingTest extends TestCase
{
    public static function paletteClassesProvider(): iterable
    {
        yield from [
            // [$class, $count, $interval]
            // #00
            [Char\Aesthetic::class, 11, 80],
            [Char\Ascii::class, 4, 300],
            [Char\ChristmasTree::class, 2, 500],
            [Char\Clock::class, 24, 300],
            [Char\ClockHourly::class, 12, 300],
            // #05
            [Char\Diamond::class, 1, null],
            [Char\Dice::class, 6, 80],
            [Char\Dot::class, 8, 160],
            [Char\DotBinaryCount::class, 256, 1000],
            [Char\Earth::class, 3, 300],
            // #10
            [Char\FeatheredArrow::class, 8, 160],
            [Char\FingerDance::class, 6, 300],
            [Char\FistBump::class, 10, 80],
            [Char\HalfCircle::class, 4, 160],
            [Char\MindBlown::class, 19, 200],
            // #15
            [Char\Monkey::class, 4, 300],
            [Char\Moon::class, 8, 300],
            [Char\PulseBlue::class, 5, 100],
            [Char\PulseOrange::class, 5, 100],
            [Char\PulseOrangeBlue::class, 12, 100],
            // #20
            [Char\RainyWeather::class, 19, 80],
            [Char\Runner::class, 2, 300],
            [Char\Sector::class, 4, 160],
            [Char\ShortSnake::class, 10, 80],
            [Char\Speaker::class, 4, 300],
            // #25
            [Char\Square::class, 8, 120],
            [Char\SquareToggle::class, 4, 500],
            [Char\StormyWeather::class, 61, 80],
            [Char\SwirlingDots::class, 56, 80],
            [Char\Toggle::class, 2, 500],
            [Char\Quadrant::class, 4, 300],
            // #30
        ];
    }

    #[Test]
    #[DataProvider('paletteClassesProvider')]
    public function canBeInstantiated(string $class): void
    {
        /** @var ICharPalette $palette */
        $palette = new $class();

        self::assertInstanceOf($class, $palette);
    }

    #[Test]
    #[DataProvider('paletteClassesProvider')]
    public function hasCorrectCount(string $class, int $count): void
    {
        /** @var ICharPalette $palette */
        $palette = new $class();

        self::assertSame($count, $this->countFrames($palette));
    }

    private function countFrames(ICharPalette $palette): int
    {
        $first = $palette->getFrame();
        $count = 1;
        while ($palette->getFrame() !== $first) {
            $count++;
        }
        return $count;
    }

    #[Test]
    #[DataProvider('paletteClassesProvider')]
    public function hasCorrectInterval(string $class, int $_, ?int $interval): void
    {
        /** @var ICharPalette $palette */
        $palette = new $class();

        self::assertSame($interval, $palette->getOptions()->getInterval());
    }
}
