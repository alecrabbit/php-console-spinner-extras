<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

interface IIndexConverter
{
    public function convert(int $input): int;

    public function getStartCodepoint(): int;
}
