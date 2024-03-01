<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateFactory;
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
    private ?ISequenceStateFactory $stateFactory = null;
    private ?ISequenceState $state = null;

    public function build(): IExtrasSpinner
    {
        if ($this->widget === null) {
            throw new LogicException('Widget is not set.');
        }

        if ($this->stateFactory === null) {
            throw new LogicException('StateFactory is not set.');
        }

        if ($this->state === null) {
            $this->state = $this->stateFactory->create();
        }

        return new ExtrasSpinner(
            widget: $this->widget,
            stateFactory: $this->stateFactory,
            state: $this->state,
            observer: $this->observer,
        );
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

    public function withStateFactory(ISequenceStateFactory $stateFactory): IExtrasSpinnerBuilder
    {
        $clone = clone $this;
        $clone->stateFactory = $stateFactory;
        return $clone;
    }

    public function withInitialState(ISequenceState $state): ISpinnerBuilder
    {
        $clone = clone $this;
        $clone->state = $state;
        return $clone;
    }
}
