<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value\A;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Value\Contract\IFloatWrapper;

abstract class AFloatWrapper extends ASubject implements IFloatWrapper
{
    protected float $value;

    /**
     * @throws InvalidArgument
     */
    public function __construct(
        float $startValue = 0.0,
        protected readonly float $min = 0.0,
        protected readonly float $max = 1.0,
        ?IObserver $observer = null,
    ) {
        self::assertRange($this->min, $this->max);

        parent::__construct($observer);
        $this->set($startValue);
    }

    /**
     * @throws InvalidArgument
     */
    private static function assertRange(float $min, float $max): void
    {
        match (true) {
            $min > $max => throw new InvalidArgument(
                sprintf(
                    'Max value should be greater than min value. Min: "%s", Max: "%s".',
                    $min,
                    $max,
                )
            ),
            $min === $max => throw new InvalidArgument(
                'Min and Max values cannot be equal.'
            ),
            default => null,
        };
    }

    protected function set(float $value): void
    {
        $this->value = $this->refineValue($value);

        $this->notify();
    }

    protected function refineValue(float $value): float
    {
        return max($this->min, min($value, $this->max));
    }

    public function getMin(): float
    {
        return $this->min;
    }

    public function getMax(): float
    {
        return $this->max;
    }

    public function unwrap(): float
    {
        return $this->value;
    }
}
