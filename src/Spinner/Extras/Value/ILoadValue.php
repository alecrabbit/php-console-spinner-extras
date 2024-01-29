<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Extras\Contract\IFloatValue;

interface ILoadValue extends ISubject, IFloatValue
{
    public function setLoad(float $load): void;
}
