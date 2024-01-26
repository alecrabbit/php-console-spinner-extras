<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

interface ILoadToSymbolHelper
{
    public function get(float $input): string;
}
