<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

interface ISequenceHelper
{
    /**
     * @deprecated Use getCodepoint() instead
     */
    public function get(int $input): string;

    public function getCodepoint(int $input): int;
}
