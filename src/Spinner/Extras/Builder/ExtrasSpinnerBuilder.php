<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Builder\Contract\IExtrasSpinnerBuilder;
use AlecRabbit\Spinner\Extras\Contract\IExtrasSpinner;
use AlecRabbit\Spinner\Extras\ExtrasSpinner;

final class ExtrasSpinnerBuilder implements IExtrasSpinnerBuilder
{
    private ?IWidget $widget = null;
    private ?IObserver $observer = null;
    private ?ISequenceStateBuilder $stateBuilder = null;
    private ?ISequenceState $state = null;

    public function build(): IExtrasSpinner
    {
        if ($this->widget === null) {
            throw new LogicException('Widget is not set.');
        }
        
        if ($this->stateBuilder === null) {
            throw new LogicException('StateBuilder is not set.');
        }

        if ($this->state === null) {
            $this->state = $this->createInitialState();
        }

        return new ExtrasSpinner(
            widget: $this->widget,
            stateBuilder: $this->stateBuilder,
            state: $this->state,
            observer: $this->observer,
        );
    }

    private function createInitialState(): ISequenceState
    {
        return $this->stateBuilder
            ->withSequence('')
            ->withWidth(0)
            ->withPreviousWidth(0)
            ->build()
        ;
    }

    public function withWidget(IWidget $widget): IExtrasSpinnerBuilder
    {
        $clone = clone $this;
        $clone->widget = $widget;
        return $clone;
    }

    public function withObserver(IObserver $observer): IExtrasSpinnerBuilder
    {
        $clone = clone $this;
        $clone->observer = $observer;
        return $clone;
    }

    public function withStateBuilder(ISequenceStateBuilder $stateBuilder): IExtrasSpinnerBuilder
    {
        $clone = clone $this;
        $clone->stateBuilder = $stateBuilder;
        return $clone;
    }
}
