<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateFactory;
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

        $state = $this->getStateMock();
        $widget = $this->getWidgetMock();
        $observer = $this->getObserverMock();
        $stateFactory = $this->getStateFactoryMock();

        $spinner = $builder
            ->withWidget($widget)
            ->withObserver($observer)
            ->withStateFactory($stateFactory)
            ->withInitialState($state)
            ->build()
        ;

        self::assertInstanceOf(ExtrasSpinner::class, $spinner);
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

    #[Test]
    public function throwsIfStateFactoryIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $widget = $this->getWidgetMock();
        $observer = $this->getObserverMock();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('StateFactory is not set.');

        $builder
            ->withWidget($widget)
            ->withObserver($observer)
            ->build()
        ;
    }

    private function getStateFactoryMock(): MockObject&ISequenceStateFactory
    {
        return $this->createMock(ISequenceStateFactory::class);
    }

    private function getStateMock(): MockObject&ISequenceState
    {
        return $this->createMock(ISequenceState::class);
    }
}
