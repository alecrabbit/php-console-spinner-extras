<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi8ColorDegrader;

final readonly class Ansi8ColorDegrader implements IAnsi8ColorDegrader
{
    public function degrade(int $r, int $g, int $b): int
    {
        if ($r === $g && $g === $b) {
            return $this->degradeFrom($r);
        }

        return 16 +
            (36 * (int)round($r / 255 * 5)) +
            (6 * (int)round($g / 255 * 5)) +
            (int)round($b / 255 * 5);
    }

    private function degradeFrom(int $v): int
    {
        if ($v < 8) {
            return 16;
        }

        if ($v > 248) {
            return 231;
        }

        return (int)round(($v - 8) / 247 * 24) + 232;
    }
}
