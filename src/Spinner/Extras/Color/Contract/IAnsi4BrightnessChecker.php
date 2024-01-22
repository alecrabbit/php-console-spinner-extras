<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color\Contract;

use AlecRabbit\Color\Contract\IHexColor;

interface IAnsi4BrightnessChecker
{
    public function isBright(IHexColor $color): bool;
}
