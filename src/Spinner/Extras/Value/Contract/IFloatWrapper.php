<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value\Contract;

use AlecRabbit\Spinner\Contract\ISubject;

interface IFloatWrapper extends IValueWrapper, ISubject
{
    public function unwrap(): float;

    public function getMin(): float;

    public function getMax(): float;
}
