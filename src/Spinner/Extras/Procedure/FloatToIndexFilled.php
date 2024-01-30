<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

final readonly class FloatToIndexFilled implements IFloatToIndex
{
    public function get(float $input): int
    {
        return match (true) {
            $input < 0.125 => 0,
            $input < 0.375 => 1,
            $input < 0.625 => 3,
            $input < 0.875 => 7,
            default => 15,
        };
    }
}
