<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value\Contract;

use DateTimeImmutable;

interface ITimerValue extends IValueWrapper
{
    public function unwrap(): DateTimeImmutable;
}
