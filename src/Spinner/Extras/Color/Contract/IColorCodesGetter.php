<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color\Contract;

interface IColorCodesGetter
{
    public function getCodes(int $r, int $g, int $b): iterable;
}
