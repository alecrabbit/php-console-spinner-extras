<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Core\Contract\ISpinner;

interface IExtrasSpinner extends ISpinner
{
    public function add(IWidgetContext $element): IWidgetContext;

    public function remove(IWidgetContext $element): void;
}
