<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color\A;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Color\Mixin\Ansi8ColorTableTrait;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class AAnsiColor
{
    use Ansi8ColorTableTrait;

    /**
     * @throws InvalidArgument
     */
    public static function getIndex(string $hex): ?int
    {
        static::assertHexStringColor($hex);
        return static::getColors()[$hex] ?? null;
    }

    /**
     * @throws InvalidArgument
     */
    protected static function assertHexStringColor(string $hex): void
    {
        Asserter::assertHexStringColor($hex);
    }

    abstract protected static function getColors(): array;

    /**
     * @throws InvalidArgument
     */
    public static function getHexColor(int $index): string
    {
        static::assertIndex($index);
        return self::COLORS[$index];
    }

    /**
     * @throws InvalidArgument
     */
    abstract protected static function assertIndex(int $index): void;
}
