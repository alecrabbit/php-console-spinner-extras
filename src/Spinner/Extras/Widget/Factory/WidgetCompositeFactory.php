<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Extras\Widget\Contract\Builder\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Extras\Widget\Contract\Factory\IWidgetCompositeFactory;

final readonly class WidgetCompositeFactory implements IWidgetCompositeFactory
{
    public function __construct(
        private IWidgetConfigFactory $widgetConfigFactory,
        private IWidgetCompositeBuilder $widgetBuilder,
        private IWidgetRevolverFactory $widgetRevolverFactory,
        private IIntervalComparator $intervalComparator,
        private IWidgetConfig|IWidgetSettings|null $widgetSettings = null,
    ) {
    }

    public function create(): IWidgetComposite
    {
        $widgetConfig = $this->widgetConfigFactory->create($this->widgetSettings);

        $revolver = $this->widgetRevolverFactory->create($widgetConfig->getWidgetRevolverConfig());

        return $this->widgetBuilder
            ->withLeadingSpacer($widgetConfig->getLeadingSpacer())
            ->withTrailingSpacer($widgetConfig->getTrailingSpacer())
            ->withWidgetRevolver($revolver)
            ->withIntervalComparator($this->intervalComparator)
            ->build()
        ;
    }

    public function usingSettings(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetCompositeFactory
    {
        return new self(
            widgetConfigFactory: $this->widgetConfigFactory,
            widgetBuilder: $this->widgetBuilder,
            widgetRevolverFactory: $this->widgetRevolverFactory,
            intervalComparator: $this->intervalComparator,
            widgetSettings: $widgetSettings,
        );
    }
}
