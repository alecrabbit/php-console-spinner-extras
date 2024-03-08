<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Widget\Factory;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
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

    #[Test]
    public function canCreateWidgetWithWidgetSettings(): void
    {
        $leadingSpacer = $this->getSequenceFrameMock();
        $trailingSpacer = $this->getSequenceFrameMock();
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

    protected function getSequenceFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    protected function getRevolverConfigMock(): MockObject&IWidgetRevolverConfig
    {
        return $this->createMock(IWidgetRevolverConfig::class);
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    protected function getWidgetConfigMock(): MockObject&IWidgetConfig
    {
        return $this->createMock(IWidgetConfig::class);
    }

    private function getWidgetSettingsMock(): MockObject&IWidgetSettings
    {
        return $this->createMock(IWidgetSettings::class);
    }

    private function getWidgetConfigFactoryMock(): MockObject&IWidgetConfigFactory
    {
        return $this->createMock(IWidgetConfigFactory::class);
    }

    protected function getWidgetCompositeMock(): MockObject&IWidgetComposite
    {
        return $this->createMock(IWidgetComposite::class);
    }

    protected function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

    private function getWidgetRevolverFactoryMock(): MockObject&IWidgetRevolverFactory
    {
        return $this->createMock(IWidgetRevolverFactory::class);
    }

    private function getWidgetCompositeBuilderMock(): MockObject&IWidgetCompositeBuilder
    {
        return $this->createMock(IWidgetCompositeBuilder::class);
    }
}
