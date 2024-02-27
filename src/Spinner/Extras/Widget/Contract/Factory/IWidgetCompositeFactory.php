<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget\Contract\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;

interface IWidgetCompositeFactory extends IWidgetFactory
{
    public function create(): IWidgetComposite;

    public function usingSettings(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetCompositeFactory;
}
