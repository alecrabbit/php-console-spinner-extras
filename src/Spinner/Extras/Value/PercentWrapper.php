<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value;

use AlecRabbit\Spinner\Extras\Value\A\AFloatWrapper;
use AlecRabbit\Spinner\Extras\Value\Contract\IPercentWrapper;

final class PercentWrapper extends AFloatWrapper implements IPercentWrapper
{
    public function setPercent(float $percent): void
    {
        $this->set($percent);
    }
}
