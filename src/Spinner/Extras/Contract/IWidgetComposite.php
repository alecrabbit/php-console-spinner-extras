<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;

interface IWidgetComposite extends IWidget,
                                   IObserver
{
    public function add(IWidgetContext $context): IWidgetContext;

    public function remove(IWidgetContext $context): void;

    public function getContext(): IWidgetContext;
}
