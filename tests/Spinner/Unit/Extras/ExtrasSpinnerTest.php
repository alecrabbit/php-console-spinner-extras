<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateFactory;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\ObserverCanNotBeOverwritten;
use AlecRabbit\Spinner\Extras\Contract\IExtrasSpinner;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Contract\IWidgetContext;
use AlecRabbit\Spinner\Extras\Exception\WidgetIsNotAComposite;
use AlecRabbit\Spinner\Extras\ExtrasSpinner;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ExtrasSpinnerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $spinner = $this->getTesteeInstance();

        self::assertInstanceOf(ExtrasSpinner::class, $spinner);
    }

    protected function getTesteeInstance(
        ?IWidget $widget = null,
        ?ISequenceStateFactory $stateFactory = null,
        ?ISequenceState $state = null,
        ?IObserver $observer = null,
    ): IExtrasSpinner {
        return new ExtrasSpinner(
            widget: $widget ?? $this->getWidgetMock(),
            stateFactory: $stateFactory ?? $this->getStateFactoryMock(),
            state: $state ?? $this->getStateMock(),
            observer: $observer,
        );
    }

    protected function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    private function getStateFactoryMock(): MockObject&ISequenceStateFactory
    {
        return $this->createMock(ISequenceStateFactory::class);
    }

    private function getStateMock(): MockObject&ISequenceState
    {
        return $this->createMock(ISequenceState::class);
    }

    private function getSequenceFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    #[Test]
    public function canGetInitialState(): void
    {
        $widget = $this->getWidgetMock();
        $widget
            ->expects($this->never())
            ->method('getFrame')
        ;

        $initialState = $this->getStateMock();
        $stateFactory = $this->getStateFactoryMock();
        $stateFactory
            ->expects(self::never())
            ->method('create')
        ;

        $spinner = $this->getTesteeInstance(
            widget: $widget,
            stateFactory: $stateFactory,
            state: $initialState,
        );

        self::assertSame($initialState, $spinner->getState());
    }

    #[Test]
    public function canNotifyOnUpdateFromRootWidget(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $observer = $this->getObserverMock();
        $observer
            ->expects(self::once())
            ->method('update')
        ;
        $spinner = $this->getTesteeInstance(
            widget: $rootWidget,
            observer: $observer
        );

        self::assertInstanceOf(ExtrasSpinner::class, $spinner);

        $spinner->update($rootWidget);
    }

    protected function getWidgetCompositeMock(): MockObject&IWidgetComposite
    {
        return $this->createMock(IWidgetComposite::class);
    }

    protected function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function willNotNotifyOnUpdateFromOtherWidget(): void
    {
        $otherWidget = $this->getWidgetMock();
        $rootWidget = $this->getWidgetCompositeMock();
        $observer = $this->getObserverMock();
        $observer
            ->expects(self::never())
            ->method('update')
        ;
        $spinner = $this->getTesteeInstance(
            widget: $rootWidget,
            observer: $observer
        );

        self::assertInstanceOf(ExtrasSpinner::class, $spinner);

        $spinner->update($otherWidget);
    }

    #[Test]
    public function canBeAttachedAsObserverToRootWidget(): void
    {
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('attach')
        ;

        $spinner = $this->getTesteeInstance(
            widget: $rootWidget,
        );

        self::assertInstanceOf(ExtrasSpinner::class, $spinner);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $spinner = $this->getTesteeInstance(widget: $rootWidget);

        self::assertInstanceOf(ExtrasSpinner::class, $spinner);
        self::assertSame($interval, $spinner->getInterval());
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canAttachObserver(): void
    {
        $spinner = $this->getTesteeInstance();

        $observer = $this->getObserverMock();

        self::assertNull(self::getPropertyValue('observer', $spinner));

        $spinner->attach($observer);

        self::assertSame($observer, self::getPropertyValue('observer', $spinner));
    }

    #[Test]
    public function canDetachObserver(): void
    {
        $observer = $this->getObserverMock();

        $spinner = $this->getTesteeInstance(
            observer: $observer
        );

        self::assertSame($observer, self::getPropertyValue('observer', $spinner));

        $spinner->detach($observer);

        self::assertNull(self::getPropertyValue('observer', $spinner));
    }

    #[Test]
    public function canAddWidget(): void
    {
        $context = $this->getWidgetContextMock();

        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('add')
            ->willReturn($context)
        ;

        $spinner = $this->getTesteeInstance(widget: $rootWidget);

        self::assertInstanceOf(ExtrasSpinner::class, $spinner);
        self::assertSame($context, $spinner->add($context));
    }

    protected function getWidgetContextMock(): MockObject&IWidgetContext
    {
        return $this->createMock(IWidgetContext::class);
    }

    #[Test]
    public function canRemoveWidget(): void
    {
        $context = $this->getWidgetContextMock();
        $rootWidget = $this->getWidgetCompositeMock();
        $rootWidget
            ->expects(self::once())
            ->method('remove')
        ;

        $spinner = $this->getTesteeInstance(widget: $rootWidget);

        self::assertInstanceOf(ExtrasSpinner::class, $spinner);
        $spinner->remove($context);
    }

    #[Test]
    public function throwsIfObserverAlreadyAttached(): void
    {
        $exceptionClass = ObserverCanNotBeOverwritten::class;
        $exceptionMessage = 'Observer is already attached.';

        $test = function (): void {
            $observer = $this->getObserverMock();
            $spinner = $this->getTesteeInstance(
                observer: $observer
            );
            $spinner->attach($observer);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfObserverAttachedIsSelf(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage = 'Object can not be self.';

        $test = function (): void {
            $spinner = $this->getTesteeInstance();
            $spinner->attach($spinner);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsOnAddIfRootWidgetIsNotAComposite(): void
    {
        $exceptionClass = WidgetIsNotAComposite::class;
        $exceptionMessage = 'Root widget is not a composite.';

        $test = function (): void {
            $context = $this->getWidgetContextMock();

            $rootWidget = $this->getWidgetMock();

            $spinner = $this->getTesteeInstance(widget: $rootWidget);

            self::assertSame($context, $spinner->add($context));
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    protected function getFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }
}
