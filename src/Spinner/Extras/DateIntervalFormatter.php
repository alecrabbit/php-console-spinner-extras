<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use ArrayObject;
use DateInterval;

final readonly class DateIntervalFormatter implements IDateIntervalFormatter
{
    private ArrayObject $labels;

    public function __construct(
        null|ArrayObject $labels = null,
    ) {
        $this->labels = $this->refineLabels($labels);
    }

    protected function refineLabels(?ArrayObject $labels): ArrayObject
    {
        return $labels ?? new ArrayObject([
            'y' => 'y',
            'd' => 'd',
            'h' => 'h',
            'm' => 'min',
            's' => 'sec',
        ]);
    }

    public function format(DateInterval $interval): string
    {
        return match (true) {
            $interval->y > 0 => $interval->format('%y ' . $this->labels['y']),
            $interval->days > 0 => $interval->format('%a ' . $this->labels['d']),
            $interval->h > 0 => $interval->format('%h ' . $this->labels['h']),
            $interval->i > 0 => $interval->format('%i ' . $this->labels['m']),
            $interval->s > 0 => $interval->format('%s ' . $this->labels['s']),
            default => '0 ' . $this->labels['s'],
        };
    }
}
