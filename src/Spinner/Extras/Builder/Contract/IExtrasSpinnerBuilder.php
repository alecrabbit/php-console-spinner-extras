<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Builder\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Extras\Contract\IExtrasSpinner;

interface IExtrasSpinnerBuilder extends ISpinnerBuilder
{
    public function build(): IExtrasSpinner;

    public function withWidget(IWidget $widget): IExtrasSpinnerBuilder;

    public function withStateBuilder(ISequenceStateBuilder $stateBuilder): IExtrasSpinnerBuilder;

    public function withObserver(IObserver $observer): IExtrasSpinnerBuilder;
}
