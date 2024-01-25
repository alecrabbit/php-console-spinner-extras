<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use DateInterval;

final readonly class EstimatedDateIntervalFormatter implements IDateIntervalFormatter
{
    public function __construct(
        private ILabels $labels = new Labels(),
    ) {
    }

    public function format(DateInterval $interval): string
    {
        $values = [];
        $label = '';
        $factor = 100; // does not represent any real value

        if ($interval->s > 0) {
            $values[5] = $interval->s;
            $label = $this->labels->second();
        }
        if ($interval->i > 0) {
            $values[4] = $interval->i;
            $label = $this->labels->minute();
            $factor = 60;
        }
        if ($interval->h > 0) {
            $values[3] = $interval->h;
            $label = $this->labels->hour();
            $factor = 60;
        }
        if ($interval->d > 0) {
            $values[2] = $interval->d;
            $label = $this->labels->day();
            $factor = 24;
        }
        if ($interval->m > 0) {
            $values[1] = $interval->m;
            $label = $this->labels->month();
            $factor = 30;
        }
        if ($interval->y > 0) {
            $values[0] = $interval->y;
            $label = $this->labels->year();
            $factor = 12;
        }

        if (count($values) > 1) {
            $values = array_slice(array_reverse($values, true), 0, 2);
        }

        $value = array_shift($values) + ((array_shift($values) ?? 0) > ($factor / 2) ? 1 : 0);

        return $value === 0
            ? '' :
            $value . $label;
    }
}
