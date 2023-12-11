<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Exception\InvalidArgument;

/**
 * @deprecated
 */
final class Asserter
{
    /**
     * @throws InvalidArgument
     */
    public static function assertHexStringColor(string $entry): void
    {
        $strlen = strlen($entry);
        $entry = strtolower($entry);
        match (true) {
            0 === $strlen => throw new InvalidArgument(
                'Value should not be empty string.'
            ),
            !str_starts_with($entry, '#') => throw new InvalidArgument(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. No "#" found.',
                    $entry
                )
            ),
            $strlen !== 4 && $strlen !== 7 => throw new InvalidArgument(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. Length: %d.',
                    $entry,
                    $strlen
                )
            ),
            default => null,
        };
    }

    /**
     * @throws InvalidArgument
     */
    public static function assertIntColor(
        int $color,
        StylingMethodOption $styleMode,
        ?string $callerMethod = null
    ): void {
        match (true) {
            0 > $color => throw new InvalidArgument(
                sprintf(
                    'Value should be positive integer, %d given.',
                    $color,
                )
            ),
            StylingMethodOption::ANSI24->name === $styleMode->name => throw new InvalidArgument(
                sprintf(
                    'For %s::%s style mode rendering from int is not allowed.',
                    StylingMethodOption::class,
                    StylingMethodOption::ANSI24->name,
                )
            ),
            StylingMethodOption::ANSI8->name === $styleMode->name && 255 < $color => throw new InvalidArgument(
                sprintf(
                    'For %s::%s style mode value should be in range 0..255, %d given.',
                    StylingMethodOption::class,
                    StylingMethodOption::ANSI8->name,
                    $color,
                )
            ),
            StylingMethodOption::ANSI4->name === $styleMode->name && 16 < $color => throw new InvalidArgument(
                sprintf(
                    'For %s::%s style mode value should be in range 0..15, %d given.',
                    StylingMethodOption::class,
                    StylingMethodOption::ANSI4->name,
                    $color,
                )
            ),
            default => null,
        };
    }
}
