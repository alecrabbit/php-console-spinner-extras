<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Widget\Factory;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use AlecRabbit\Spinner\Extras\Settings\Contract\IMultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Widget\Contract\Builder\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Extras\Widget\Contract\Factory\IWidgetCompositeFactory;
use AlecRabbit\Spinner\Extras\Widget\Factory\WidgetCompositeFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetCompositeFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);
    }

    public function getTesteeInstance(
        ?IWidgetConfigFactory $widgetConfigFactory = null,
        ?IWidgetCompositeBuilder $widgetBuilder = null,
        ?IWidgetRevolverFactory $widgetRevolverFactory = null,
        ?IIntervalComparator $intervalComparator = null,
    ): IWidgetCompositeFactory {
        return
            new WidgetCompositeFactory(
                widgetConfigFactory: $widgetConfigFactory ?? $this->getWidgetConfigFactoryMock(),
                widgetBuilder: $widgetBuilder ?? $this->getWidgetCompositeBuilderMock(),
                widgetRevolverFactory: $widgetRevolverFactory ?? $this->getWidgetRevolverFactoryMock(),
                intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
            );
    }

    private function getWidgetConfigFactoryMock(): MockObject&IWidgetConfigFactory
    {
        return $this->createMock(IWidgetConfigFactory::class);
    }

    private function getWidgetCompositeBuilderMock(): MockObject&IWidgetCompositeBuilder
    {
        return $this->createMock(IWidgetCompositeBuilder::class);
    }

    private function getWidgetRevolverFactoryMock(): MockObject&IWidgetRevolverFactory
    {
        return $this->createMock(IWidgetRevolverFactory::class);
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    #[Test]
    public function canCreateWidgetWithoutWidgetSettings(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $revolverConfig = $this->getRevolverConfigMock();
        $intervalComparator = $this->getIntervalComparatorMock();
        $widgetConfig = $this->getWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($leadingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($trailingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getWidgetRevolverConfig')
            ->willReturn($revolverConfig)
        ;

        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo(null))
            ->willReturn($widgetConfig)
        ;

        $widget = $this->getWidgetCompositeMock();

        $widgetRevolver = $this->getWidgetRevolverMock();

        $widgetRevolverFactory = $this->getWidgetRevolverFactoryMock();
        $widgetRevolverFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo($revolverConfig))
            ->willReturn($widgetRevolver)
        ;

        $widgetBuilder = $this->getWidgetCompositeBuilderMock();
        $widgetBuilder
            ->expects(self::once())
            ->method('withLeadingSpacer')
            ->with(self::identicalTo($leadingSpacer))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withTrailingSpacer')
            ->with(self::identicalTo($trailingSpacer))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withWidgetRevolver')
            ->with(self::identicalTo($widgetRevolver))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withIntervalComparator')
            ->with(self::identicalTo($intervalComparator))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($widget)
        ;

        $widgetFactory = $this->getTesteeInstance(
            widgetConfigFactory: $widgetConfigFactory,
            widgetBuilder: $widgetBuilder,
            widgetRevolverFactory: $widgetRevolverFactory,
            intervalComparator: $intervalComparator,
        );

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);
        self::assertSame($widget, $widgetFactory->create());
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }

    protected function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    protected function getWidgetCompositeMock(): MockObject&IWidgetComposite
    {
        return $this->createMock(IWidgetComposite::class);
    }

    protected function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

    #[Test]
    public function canCreateWidgetWithWidgetSettings(): void
    {
        $leadingSpacer = $this->getFrameMock();
        $trailingSpacer = $this->getFrameMock();
        $revolverConfig = $this->getRevolverConfigMock();
        $intervalComparator = $this->getIntervalComparatorMock();
        $widgetConfig = $this->getWidgetConfigMock();
        $widgetConfig
            ->expects(self::once())
            ->method('getLeadingSpacer')
            ->willReturn($leadingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getTrailingSpacer')
            ->willReturn($trailingSpacer)
        ;
        $widgetConfig
            ->expects(self::once())
            ->method('getWidgetRevolverConfig')
            ->willReturn($revolverConfig)
        ;
        $widgetSettings = $this->getWidgetSettingsMock();
        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo($widgetSettings))
            ->willReturn($widgetConfig)
        ;

        $widget = $this->getWidgetCompositeMock();

        $widgetRevolver = $this->getWidgetRevolverMock();

        $widgetRevolverFactory = $this->getWidgetRevolverFactoryMock();
        $widgetRevolverFactory
            ->expects(self::once())
            ->method('create')
            ->with(self::identicalTo($revolverConfig))
            ->willReturn($widgetRevolver)
        ;

        $widgetBuilder = $this->getWidgetCompositeBuilderMock();
        $widgetBuilder
            ->expects(self::once())
            ->method('withLeadingSpacer')
            ->with(self::identicalTo($leadingSpacer))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withTrailingSpacer')
            ->with(self::identicalTo($trailingSpacer))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withWidgetRevolver')
            ->with(self::identicalTo($widgetRevolver))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('withIntervalComparator')
            ->with(self::identicalTo($intervalComparator))
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($widget)
        ;

        $widgetFactory = $this->getTesteeInstance(
            widgetConfigFactory: $widgetConfigFactory,
            widgetBuilder: $widgetBuilder,
            widgetRevolverFactory: $widgetRevolverFactory,
            intervalComparator: $intervalComparator,
        );

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);
        self::assertSame($widget, $widgetFactory->usingSettings($widgetSettings)->create());
    }

    private function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    #[Test]
    public function canCreateWidgetWithMultiWidgetSettings(): void
    {
        $intervalComparator = $this->getIntervalComparatorMock();
        $widgetSettingsFirst = $this->getWidgetSettingsMock();
        $widgetSettingsSecond = $this->getWidgetSettingsMock();
        $widgetSettingsThird = $this->getWidgetSettingsMock();
        $widgetSettingsFourth = $this->getWidgetSettingsMock();


        $multiWidgetSettings = $this->getMultiWidgetSettingsMock();
        $multiWidgetSettings
            ->expects(self::once())
            ->method('getFirst')
            ->willReturn($widgetSettingsFirst)
        ;
        $multiWidgetSettings
            ->expects(self::once())
            ->method('getOther')
            ->willReturn(
                new \ArrayObject(
                    [
                        $widgetSettingsSecond,
                        $widgetSettingsThird,
                        $widgetSettingsFourth
                    ]
                )
            )
        ;

        $widgetConfigFactory = $this->getWidgetConfigFactoryMock();
        $widgetConfigFactory
            ->expects(self::exactly(4))
            ->method('create')
            ->willReturn($this->getWidgetConfigMock())
        ;

        $firstWidget = $this->getWidgetCompositeMock();
        $secondWidget = $this->getWidgetCompositeMock();
        $thirdWidget = $this->getWidgetCompositeMock();
        $fourthWidget = $this->getWidgetCompositeMock();

        $widgetRevolverFactory = $this->getWidgetRevolverFactoryMock();
        $widgetRevolverFactory
            ->expects(self::exactly(4))
            ->method('create')
            ->willReturn($this->getWidgetRevolverMock())
        ;

        $widgetBuilder = $this->getWidgetCompositeBuilderMock();
        $widgetBuilder
            ->expects(self::exactly(4))
            ->method('withLeadingSpacer')
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::exactly(4))
            ->method('withTrailingSpacer')
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::exactly(4))
            ->method('withWidgetRevolver')
            ->willReturnSelf()
        ;
        $widgetBuilder
            ->expects(self::exactly(4))
            ->method('withIntervalComparator')
            ->willReturnSelf()
        ;

        $widgetBuilder
            ->expects(self::exactly(4))
            ->method('build')
            ->willReturnOnConsecutiveCalls(
                $firstWidget,
                $secondWidget,
                $thirdWidget,
                $fourthWidget,
            )
        ;

        $firstWidget
            ->expects(self::exactly(3))
            ->method('add')
            ->willReturn($this->getWidgetContextMock())
        ;

        $secondWidget
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($this->getWidgetContextMock())
        ;

        $thirdWidget
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($this->getWidgetContextMock())
        ;

        $fourthWidget
            ->expects(self::once())
            ->method('getContext')
            ->willReturn($this->getWidgetContextMock())
        ;

        $widgetFactory = $this->getTesteeInstance(
            widgetConfigFactory: $widgetConfigFactory,
            widgetBuilder: $widgetBuilder,
            widgetRevolverFactory: $widgetRevolverFactory,
            intervalComparator: $intervalComparator,
        );

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);

        $widgetComposite = $widgetFactory->usingSettings($multiWidgetSettings)->create();
        self::assertSame($firstWidget, $widgetComposite);
    }

    private function getMultiWidgetSettingsMock(): MockObject&IMultiWidgetSettings
    {
        return $this->createMock(IMultiWidgetSettings::class);
    }

    private function getWidgetContextMock(): MockObject&IWidgetContext
    {
        return $this->createMock(IWidgetContext::class);
    }

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }
}
