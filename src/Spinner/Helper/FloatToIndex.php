<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

final readonly class FloatToIndex implements IFloatToIndex
{
    public function get(float $input): int
    {
        return match (true) {
            $input < 0.125 => 0,
            $input < 0.375 => 1,
            $input < 0.625 => 2,
            $input < 0.875 => 4,
            default => 8,
        };
    }
}
