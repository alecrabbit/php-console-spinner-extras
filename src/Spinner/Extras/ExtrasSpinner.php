<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Extras\Contract\IExtrasSpinner;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Contract\IWidgetContext;
use AlecRabbit\Spinner\Extras\Exception\WidgetIsNotAComposite;

final class ExtrasSpinner extends ASubject implements IExtrasSpinner
{

    public function __construct(
        private readonly IWidget $widget,
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

    public function getFrame(?float $dt = null): ISequenceFrame
    {
        return $this->widget->getFrame($dt);
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
}
