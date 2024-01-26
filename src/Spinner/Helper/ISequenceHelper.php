<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

interface ISequenceHelper
{
    public function get(int $input): string;

    public function getBraille(int $input): string;
}
