<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Color\Contract\IHexColor;

final readonly class Ansi4BrightnessChecker implements Contract\IAnsi4BrightnessChecker
{
    public function isBright(IHexColor $color): bool
    {
        return false;
    }
}
