<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;

final readonly class Ansi4ColorCodesGetter implements IColorCodesGetter
{
    public function __construct(
        private IAnsi4ColorDegrader $ansi4ColorDegrader,
    ) {
    }
    public function getCodes(int $r, int $g, int $b): iterable
    {
        return [$this->ansi4ColorDegrader->degrade($r, $g, $b)];
    }
}
