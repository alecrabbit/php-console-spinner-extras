<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Color\Contract\IColor;

interface IColorToAnsiCodeConverter
{
    public function convert(IColor|string $color): IAnsiCode;
}
