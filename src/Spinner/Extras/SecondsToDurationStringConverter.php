<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\Contract\ISecondsToDurationStringConverter;

final readonly class SecondsToDurationStringConverter implements ISecondsToDurationStringConverter
{
    private const MINUTE = 60;
    private const HOUR = 60 * self::MINUTE;
    private const DAY = 24 * self::HOUR;
    private const MONTH = 30 * self::DAY;
    private const YEAR = 365 * self::DAY;

    public function convert(int $seconds): string
    {
        return sprintf(
            'P%dY%dM%dDT%dH%dM%dS',
            (int)floor($seconds / self::YEAR),
            (int)floor(($seconds % self::YEAR) / self::MONTH),
            (int)floor(($seconds % self::MONTH) / self::DAY),
            (int)floor(($seconds % self::DAY) / self::HOUR),
            (int)floor(($seconds % self::HOUR) / self::MINUTE),
            $seconds % self::MINUTE,
        );
    }

}
