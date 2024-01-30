<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

interface IFloatToIndex
{
    public function get(float $input): int;
}
