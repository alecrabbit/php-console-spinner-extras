<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\ILabels;
use DateInterval;

final readonly class FineDateIntervalFormatter implements IDateIntervalFormatter
{
    public function __construct(
        private ILabels $labels = new Labels(),
    ) {
    }

    public function format(DateInterval $interval): string
    {
        $values = [];

        if ($interval->y > 0) {
            $values[] = $interval->y . $this->labels->year();
        }
        if ($interval->m > 0) {
            $values[] = $interval->m . $this->labels->month();
        }
        if ($interval->d > 0) {
            $values[] = $interval->d . $this->labels->day();
        }
        if ($interval->h > 0) {
            $values[] = $interval->h . $this->labels->hour();
        }
        if ($interval->i > 0) {
            $values[] = $interval->i . $this->labels->minute();
        }
        if ($interval->s > 0) {
            $values[] = $interval->s . $this->labels->second();
        }

        return implode(' ', $values);
    }
}
