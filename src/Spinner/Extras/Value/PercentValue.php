<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value;

use AlecRabbit\Spinner\Extras\A\AFloatValue;

final class PercentValue extends AFloatValue implements IPercentValue
{
    public function setPercent(float $percent): void
    {
        $this->set($percent);
    }
}
