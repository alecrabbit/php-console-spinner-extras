<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\Contract;

interface IIndexConverter
{
    public function convert(int $input): int;

    public function getStartCodepoint(): int;

    public function getMax(): int;
}
