<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget\Contract\Factory;

use AlecRabbit\Spinner\Extras\Contract\IProgressValue;

interface IProgressWidgetFactory extends IWidgetCompositeFactory
{
    public function usingValue(IProgressValue $value): IProgressWidgetFactory;
}
