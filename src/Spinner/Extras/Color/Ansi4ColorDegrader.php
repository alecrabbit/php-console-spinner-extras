<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4ColorDegrader;

final readonly class Ansi4ColorDegrader implements IAnsi4ColorDegrader
{
    public function degrade(int $r, int $g, int $b): int
    {
        $r = (int)round($r / 255);
        $g = (int)round($g / 255);
        $b = (int)round($b / 255);

        return $b << 2 | $g << 1 | $r;
    }
}
