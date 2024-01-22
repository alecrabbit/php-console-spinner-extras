<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Color\Contract\IColor;

interface IAnsiColorParser
{
    public function parseColor(IColor|null|string $color): IAnsiCode;
}
