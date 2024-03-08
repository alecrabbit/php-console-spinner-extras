<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Integration\Extras\Widget\Factory;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Widget\Contract\Builder\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Extras\Widget\Contract\Factory\IWidgetCompositeFactory;
use AlecRabbit\Spinner\Extras\Widget\Factory\WidgetCompositeFactory;
use AlecRabbit\Spinner\Extras\Widget\WidgetComposite;
use AlecRabbit\Tests\TestCase\FacadeAwareTestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetCompositeFactoryTest extends FacadeAwareTestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);
    }

    public function getTesteeInstance(): IWidgetCompositeFactory {
        return self::getService(IWidgetFactory::class);
    }

    #[Test]
    public function canCreateWidgetWithNestedMultiWidgetSettings(): void
    {
        $multiWidgetSettings =
            new MultiWidgetSettings(
                new WidgetSettings(),
                new WidgetSettings(),
                new MultiWidgetSettings(
                    new WidgetSettings(),
                    new WidgetSettings(),
                ),
                new WidgetSettings(),
            );

        $widgetFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);

        $widgetComposite = $widgetFactory->usingSettings($multiWidgetSettings)->create();

        self::assertInstanceOf(WidgetComposite::class, $widgetComposite);
        // TODO (2023-12-19 13:08) [Alec Rabbit]: enhance test, add checks for nested widgets
    }
}
