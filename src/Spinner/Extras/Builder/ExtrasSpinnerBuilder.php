<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Builder\Contract\IExtrasSpinnerBuilder;
use AlecRabbit\Spinner\Extras\Contract\IExtrasSpinner;
use AlecRabbit\Spinner\Extras\ExtrasSpinner;

final class ExtrasSpinnerBuilder implements IExtrasSpinnerBuilder
{
    private ?IWidget $widget = null;
    private ?IObserver $observer = null;

    public function build(): IExtrasSpinner
    {
        if ($this->widget === null) {
            throw new LogicException('Widget is not set.');
        }

        return new ExtrasSpinner(
            widget: $this->widget,
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
}
