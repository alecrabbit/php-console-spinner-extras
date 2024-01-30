<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

interface IFloatToIndex
{
    public function get(float $input): int;
}
