<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;

final readonly class Ansi8ColorCodesGetter extends AColorCodesGetter implements IColorCodesGetter
{
    public function __construct(
        private IAnsi8ColorDegrader $ansi8ColorDegrader,
    ) {
    }

    public function getCodes(int $r, int $g, int $b): iterable
    {
        return [8, 5, $this->ansi8ColorDegrader->degrade($r, $g, $b)];
    }
}
