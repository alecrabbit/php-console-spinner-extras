<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4ColorDegrader;

final readonly class Ansi4ColorDegrader implements IAnsi4ColorDegrader
{
    public function degrade(int $r, int $g, int $b): int
    {
        /** @psalm-suppress TypeDoesNotContainType */
        if (round($this->getSaturation($r, $g, $b) / 50) === 0) { // 0 === round(... - it is a hack
            return 0;
        }

        return (int)round($b / 255) << 2 | (int)round($g / 255) << 1 | (int)round($r / 255);
    }

    private function getSaturation(int $r, int $g, int $b): int
    {
        $rf = $r / 255;
        $gf = $g / 255;
        $bf = $b / 255;
        $v = max($rf, $gf, $bf);

        if (0 === $diff = $v - min($rf, $gf, $bf)) {
            return 0;
        }

        return (int)($diff * 100 / $v);
    }
}
