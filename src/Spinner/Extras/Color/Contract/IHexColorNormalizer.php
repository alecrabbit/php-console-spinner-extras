<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color\Contract;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;

interface IHexColorNormalizer
{
    public function normalize(IColor|string $color): IHexColor;
}
