<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\ISubject;

interface IFloatValue extends ISubject
{
    public function getValue(): float;

    public function getMin(): float;

    public function getMax(): float;
}
