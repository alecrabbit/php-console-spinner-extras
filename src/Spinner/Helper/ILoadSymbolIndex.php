<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;

interface ILoadSymbolIndex extends ISubject, IObserver
{
    public function get(): int;

    public function add(float $input): void;
}
