<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\IHasNullableInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;

interface IWidgetContext extends IObserver,
                                 ISubject,
                                 IHasNullableInterval
{
    public function setWidget(?IWidget $widget): void;

    public function getWidget(): ?IWidget;
}