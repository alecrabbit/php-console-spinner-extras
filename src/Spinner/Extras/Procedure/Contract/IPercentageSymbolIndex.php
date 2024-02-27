<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Extras\Value\Contract\IPercentWrapper;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;

interface IPercentageSymbolIndex extends ISubject, IObserver, IValueReference
{
    public function get(): int;

    public function getWrapper(): IPercentWrapper;
}
