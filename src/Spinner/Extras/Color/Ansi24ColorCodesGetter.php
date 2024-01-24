<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;

final readonly class Ansi24ColorCodesGetter extends AColorCodesGetter implements IColorCodesGetter
{
    public function getCodes(int $r, int $g, int $b): iterable
    {
        return [8, 2, $r, $g, $b,];
    }
}
