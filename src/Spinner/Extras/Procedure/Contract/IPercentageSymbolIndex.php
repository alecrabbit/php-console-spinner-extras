<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Extras\Value\IPercentValue;

interface IPercentageSymbolIndex extends ISubject, IObserver
{
    public function get(): int;

    public function getValue(): IPercentValue;
}
