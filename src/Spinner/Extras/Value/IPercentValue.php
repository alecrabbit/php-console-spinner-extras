<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value;

use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Extras\Contract\IFloatValue;

interface IPercentValue extends ISubject, IFloatValue
{
    public function setPercent(float $percent): void;
}
