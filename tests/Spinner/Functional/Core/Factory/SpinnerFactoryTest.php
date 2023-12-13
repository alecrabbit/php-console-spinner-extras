<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IRootWidgetConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Extras\Widget\Contract\Factory\IWidgetCompositeFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SpinnerFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $spinnerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
    }

    public function getTesteeInstance(
        ?IWidgetFactory $widgetFactory = null,
        ?IRootWidgetConfigFactory $widgetConfigFactory = null,
    ): ISpinnerFactory {
        return
            new SpinnerFactory(
                widgetFactory: $widgetFactory ?? $this->getWidgetFactoryMock(),
                widgetConfigFactory: $widgetConfigFactory ?? $this->getWidgetConfigFactoryMock(),
            );
    }

    protected function getWidgetFactoryMock(): MockObject&IWidgetFactory
    {
        return $this->createMock(IWidgetFactory::class);
    }

    protected function getWidgetConfigFactoryMock(): MockObject&IRootWidgetConfigFactory
    {
        return $this->createMock(IRootWidgetConfigFactory::class);
    }

    #[Test]
    public function canCreateUsingWidgetCompositeFactory(): void
    {
        $widgetConfig = $this->getRootWidgetConfigMock();

        $widgetFactory = $this->getWidgetCompositeFactoryMock();
        $widgetFactory
            ->expects(self::once())
            ->method('usingSettings')
            ->with(self::identicalTo($widgetConfig))
            ->willReturnSelf()
        ;
        $widgetFactory
            ->expects(self::once())
            ->method('create')
            ->with()
        ;

        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo(null))
            ->willReturn($widgetConfig)
        ;

        $spinnerFactory = $this->getTesteeInstance(
            widgetFactory: $widgetFactory,
            widgetConfigFactory: $widgetConfigFactory,
        );

        $spinner = $spinnerFactory->create();

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    protected function getRootWidgetConfigMock(): MockObject&IRootWidgetConfig
    {
        return $this->createMock(IRootWidgetConfig::class);
    }

    protected function getWidgetCompositeFactoryMock(): MockObject&IWidgetCompositeFactory
    {
        return $this->createMock(IWidgetCompositeFactory::class);
    }

    protected function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    protected function getSpinnerSettingsMock(): MockObject&ISpinnerSettings
    {
        return $this->createMock(ISpinnerSettings::class);
    }

    protected function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }
}
