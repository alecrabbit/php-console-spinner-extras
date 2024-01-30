<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

interface IIndexToCodepointConverter
{
    public function getCodepoint(int $index): int;
}
