<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Contract\ISubject;

interface ILoadValue extends ISubject
{
    public function get(): int;

    public function add(float $input): void;
}
