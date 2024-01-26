<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

interface IBitConverterHelper
{
    public function convert(int $input): int;
}
