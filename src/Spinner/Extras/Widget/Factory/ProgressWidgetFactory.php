<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Widget\Contract\Factory\IProgressWidgetFactory;
use AlecRabbit\Spinner\Extras\Widget\Contract\Factory\IWidgetCompositeFactory;

final readonly class ProgressWidgetFactory implements IProgressWidgetFactory
{

    public function usingValue(IProgressValue $value): IProgressWidgetFactory
    {
        // TODO: Implement usingValue() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }

    public function create(): IWidgetComposite
    {
        // TODO: Implement create() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }

    public function usingSettings(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetCompositeFactory
    {
        // TODO: Implement using() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
