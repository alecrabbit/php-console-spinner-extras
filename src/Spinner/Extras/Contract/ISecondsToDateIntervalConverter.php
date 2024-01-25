<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use DateInterval;

interface ISecondsToDateIntervalConverter
{
    public function convert(int $seconds): DateInterval;
}
