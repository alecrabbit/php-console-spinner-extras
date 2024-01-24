<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Mixin\Ansi8ColorTableTrait;

final readonly class Ansi8ColorDegrader implements IAnsi8ColorDegrader
{
    use Ansi8ColorTableTrait;

    private array $colors;

    public function __construct()
    {
        $this->colors = array_flip(array_slice(self::COLORS, 16, preserve_keys: true));
    }

    public function degrade(int $r, int $g, int $b): int
    {
        $index = $r << 16 | $g << 8 | $b;

        if ($this->colors[$index] ?? false) {
            return $this->colors[$index];
        }

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
