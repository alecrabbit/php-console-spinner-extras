<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value\Contract;

use AlecRabbit\Spinner\Contract\ISubject;

interface IPercentWrapper extends ISubject, IFloatWrapper
{
    public function setPercent(float $percent): void;
}
