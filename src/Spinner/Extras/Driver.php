<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\SpinnerState;
use WeakMap;

final class Driver extends ADriver
{
    /** @var WeakMap<ISpinner, ISpinnerState> */
    private readonly WeakMap $spinners;


    public function __construct(
        IDriverOutput $output,
        ITimer $timer,
        IInterval $initialInterval,
        IDriverSettings $driverSettings,
        ?IObserver $observer = null,
    ) {
        parent::__construct(
            $output,
            $timer,
            $initialInterval,
            $driverSettings,
            $observer
        );
        $this->spinners = new WeakMap();
        $this->interval = $initialInterval;
    }

    public function render(?float $dt = null): void
    {
        $dt ??= $this->timer->getDelta();

        foreach ($this->spinners as $spinner => $previousState) {
            $frame = $spinner->getFrame($dt);

            $state =
                new SpinnerState(
                    sequence: $frame->sequence(),
                    width: $frame->width(),
                    previousWidth: $previousState->getWidth()
                );

            $this->spinners->offsetSet($spinner, $state);

            $this->output->write($state);
        }
    }

    public function add(ISpinner $spinner): void
    {
        if (!$this->spinners->offsetExists($spinner)) {
            $this->spinners->offsetSet($spinner, new SpinnerState());
            $this->interval = $this->interval->smallest($spinner->getInterval());
            $spinner->attach($this);
            $this->notify();
        }
    }

    public function remove(ISpinner $spinner): void
    {
        if ($this->spinners->offsetExists($spinner)) {
            $this->eraseOne($this->spinners[$spinner]);
            $this->spinners->offsetUnset($spinner);
            $spinner->detach($this);
            $this->interval = $this->recalculateInterval();
            $this->notify();
        }
    }

    private function recalculateInterval(): IInterval
    {
        $interval = $this->initialInterval;
        foreach ($this->spinners as $spinner => $_) {
            $interval = $interval->smallest($spinner->getInterval());
        }
        return $interval;
    }

    public function update(ISubject $subject): void
    {
        if ($this->spinners->offsetExists($subject)) {
            $this->interval = $this->recalculateInterval();
            $this->notify();
        }
    }

    protected function erase(): void
    {
        /** @var ISpinnerState $state */
        foreach ($this->spinners as $state) {
            $this->eraseOne($state);
        }
    }

    private function eraseOne(ISpinnerState $state): void
    {
        $this->output->erase($state);
    }

    public function has(ISpinner $spinner): bool
    {
        // TODO: Implement has() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
