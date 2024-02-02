<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use DateInterval;

final readonly class ClockDateIntervalFormatter implements IDateIntervalFormatter
{
    public function __construct(
        private ILabels $labels = new Labels(),
    ) {
    }

    public function format(DateInterval $interval): string
    {
        $values = [];

        if ($interval->y > 0) {
            return $interval->y . $this->labels->year();
        }
        if ($interval->m > 0) {
            return $interval->m . $this->labels->month();
        }
        if ($interval->d > 0) {
            return $interval->d . $this->labels->day();
        }

        $values[] = sprintf('%02d', $interval->h);
        $values[] = sprintf('%02d', $interval->i);
        $values[] = sprintf('%02d', $interval->s);

        return implode(':', $values);
    }
}
