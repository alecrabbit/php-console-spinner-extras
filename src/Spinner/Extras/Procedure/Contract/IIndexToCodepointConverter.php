<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\Contract;

interface IIndexToCodepointConverter
{
    public function getCodepoint(int $index): int;
}
