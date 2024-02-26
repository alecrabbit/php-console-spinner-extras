<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Builder\Contract\IExtrasSpinnerBuilder;
use AlecRabbit\Spinner\Extras\Builder\ExtrasSpinnerBuilder;
use AlecRabbit\Spinner\Extras\ExtrasSpinner;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ExtrasSpinnerBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(ExtrasSpinnerBuilder::class, $builder);
    }

    public function getTesteeInstance(): IExtrasSpinnerBuilder
    {
        return new ExtrasSpinnerBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $widget = $this->getWidgetMock();
        $observer = $this->getObserverMock();
        $stateBuilder = $this->getStateBuilderMock();

        $spinner = $builder
            ->withWidget($widget)
            ->withObserver($observer)
            ->withStateBuilder($stateBuilder)
            ->build()
        ;

        self::assertInstanceOf(ExtrasSpinner::class, $spinner);
    }
    private function getStateBuilderMock(): MockObject&ISequenceStateBuilder
    {
        return $this->createMock(ISequenceStateBuilder::class);
    }
    private function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    private function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function throwsIfWidgetIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Widget is not set.');

        $builder
            ->build()
        ;
    }
}
