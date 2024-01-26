<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

interface ILoadHelper
{
    public function get(): int;

    public function add(float $input): void;
}
