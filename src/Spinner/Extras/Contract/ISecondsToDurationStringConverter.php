<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use DateInterval;

interface ISecondsToDurationStringConverter
{
    public function convert(int $seconds): string;
}
