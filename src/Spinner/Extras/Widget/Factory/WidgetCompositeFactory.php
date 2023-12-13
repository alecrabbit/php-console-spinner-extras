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

final  class WidgetCompositeFactory implements IWidgetCompositeFactory
{
    private IWidgetSettings|IWidgetConfig|null $widgetSettings = null;

    public function __construct(
        private readonly IWidgetConfigFactory $widgetConfigFactory,
        private readonly IWidgetCompositeBuilder $widgetBuilder,
        private readonly IWidgetRevolverFactory $widgetRevolverFactory,
        private readonly IIntervalComparator $intervalComparator,
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

    public function using(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetCompositeFactory
    {
        $this->widgetSettings = $widgetSettings;
        return $this;
    }
}
