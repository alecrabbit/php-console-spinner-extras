<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;

interface INeoWidgetComposite extends IWidget,
                                      IObserver
{
    public function add(IWidget $widget, ?IPlaceholder $placeholder = null): IPlaceholder;

    public function remove(IPlaceholder|IWidget $item): void;
}