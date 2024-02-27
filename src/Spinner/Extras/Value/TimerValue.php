<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value;

use AlecRabbit\Spinner\Extras\Value\Contract\ITimerValue;
use DateTimeImmutable;

final readonly class TimerValue implements ITimerValue
{
    public function __construct(
        private DateTimeImmutable $value,
    ) {
    }

    public function unwrap(): DateTimeImmutable
    {
        return $this->value;
    }
}
