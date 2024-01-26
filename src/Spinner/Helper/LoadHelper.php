<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

use Symfony\Component\VarDumper\Caster\ScalarStub;

final class LoadHelper implements ILoadHelper
{
    public function __construct(
        private int $current = 0,
    ) {
    }

    public function get(): int
    {
        return $this->current;
    }

    public function add(float $input): void
    {
        $this->current &= 0b00001111;
        $this->current <<= 4;

        $v = match (true) {
            $input < 0.125 => 0,
            $input < 0.375 => 1,
            $input < 0.625 => 3,
            $input < 0.875 => 7,
            default => 15,
        };

        $this->current |= $v;
    }
}
