<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use DateInterval;

interface IDateIntervalFormatter
{
    public function format(DateInterval $interval): string;
}