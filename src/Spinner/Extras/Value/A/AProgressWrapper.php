<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value\A;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IProgressWrapper;

abstract class AProgressWrapper extends AFloatWrapper implements IProgressWrapper
{
    protected bool $finished = false;
    protected bool $started = false;
    protected float $stepValue;

    /**
     * @throws InvalidArgument
     */
    public function __construct(
        float $startValue = 0.0,
        float $min = 0.0,
        float $max = 1.0,
        protected readonly int $steps = 100,
        protected readonly bool $autoFinish = true,
        protected readonly bool $autoStart = true,
    ) {
        parent::__construct(
            startValue: $startValue,
            min: $min,
            max: $max,
        );

        $this->autoStart();

        self::assert($this);
        $this->stepValue = ($this->max - $this->min) / $this->steps;
    }

    protected function autoStart(): void
    {
        if ($this->autoStart) {
            $this->start();
        }
    }

    public function start(): void
    {
        $this->started = true;
    }

    /**
     * @throws InvalidArgument
     */
    private static function assert(AProgressWrapper $value): void
    {
        match (true) {
            0 > $value->steps || $value->steps === 0 => throw new InvalidArgument(
                sprintf(
                    'Steps should be greater than 0. Steps: "%s".',
                    $value->steps,
                )
            ),
            default => null,
        };
    }

    public function advance(int $steps = 1): void
    {
        if ($this->finished || !$this->started) {
            return;
        }
        $this->set($this->value + $steps * $this->stepValue);

        $this->autoFinish();
    }

    protected function autoFinish(): void
    {
        if ($this->autoFinish && $this->value >= $this->max) {
            $this->finish();
        }
    }

    public function finish(): void
    {
        $this->finished = true;
        $this->value = $this->max;
    }

    public function getSteps(): int
    {
        return $this->steps;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function isStarted(): bool
    {
        return $this->started;
    }
}
