<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\A;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;

abstract class AProgressValue extends AFloatValue implements IProgressValue
{
    protected const FINISH_THRESHOLD = 0;
    protected const DECREMENT = 1;

    protected bool $finished = false;
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
        /** // FIXME (2023-12-19 16:29) [Alec Rabbit]: @deprecated */
        protected float|int $threshold = self::FINISH_THRESHOLD, // @deprecated
        /** // FIXME (2023-12-19 16:29) [Alec Rabbit]: @deprecated */
        protected readonly float|int $decrement = self::DECREMENT, // @deprecated
    )
    {
        parent::__construct(
            startValue: $startValue,
            min: $min,
            max: $max,
        );
        self::assert($this);
        $this->stepValue = ($this->max - $this->min) / $this->steps;
    }

    /**
     * @throws InvalidArgument
     */
    private static function assert(AProgressValue $value): void
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
        if ($this->finished) {
            return;
        }
        $this->setValue($this->value + $steps * $this->stepValue);

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

    public function isFinished(bool $useThreshold = false): bool
    {
        if ($this->finished && $useThreshold) {
            if ($this->threshold <= 0) {
                return $this->finished;
            }

            $this->decrementThreshold();
            return false;
        }
        return $this->finished;
    }

    protected function decrementThreshold(): void
    {
        $this->threshold -= $this->decrement;
    }
}
