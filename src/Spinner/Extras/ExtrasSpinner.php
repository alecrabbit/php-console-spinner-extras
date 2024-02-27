<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Extras\Contract\IExtrasSpinner;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Contract\IWidgetContext;
use AlecRabbit\Spinner\Extras\Exception\WidgetIsNotAComposite;

final class ExtrasSpinner extends ASubject implements IExtrasSpinner
{

    public function __construct(
        private readonly IWidget $widget,
        private readonly ISequenceStateBuilder $stateBuilder,
        private ISequenceState $state,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->widget->attach($this);
    }

    public function add(IWidgetContext $element): IWidgetContext
    {
        if ($this->widget instanceof IWidgetComposite) {
            return $this->widget->add($element);
        }
        throw new WidgetIsNotAComposite('Root widget is not a composite.');
    }

    public function remove(IWidgetContext $element): void
    {
        if ($this->widget instanceof IWidgetComposite) {
            $this->widget->remove($element);
        }
    }

    public function getInterval(): IInterval
    {
        return $this->widget->getInterval();
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->widget) {
            $this->notify();
        }
    }

    public function getState(?float $dt = null): ISequenceState
    {
        if ($dt !== null) {
            $frame = $this->widget->getFrame($dt);

            $this->state = $this->stateBuilder
                ->withSequence($frame->getSequence())
                ->withWidth($frame->getWidth())
                ->withPreviousWidth($this->state->getWidth())
                ->build()
            ;
        }

        return $this->state;
    }
}
