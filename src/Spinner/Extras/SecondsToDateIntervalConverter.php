<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\Contract\ISecondsToDateIntervalConverter;
use AlecRabbit\Spinner\Extras\Contract\ISecondsToDurationStringConverter;
use DateInterval;

final readonly class SecondsToDateIntervalConverter implements ISecondsToDateIntervalConverter
{
    public function __construct(
        private ISecondsToDurationStringConverter $duration = new SecondsToDurationStringConverter(),
    ) {
    }

    public function convert(int $seconds): DateInterval
    {
        return new DateInterval($this->duration->convert($seconds));
    }
}
