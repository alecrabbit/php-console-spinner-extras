<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\A;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IFloatValue;

abstract class AFloatValue implements IFloatValue
{
    protected float $value;

    /**
     * @throws InvalidArgument
     */
    public function __construct(
        float $startValue = 0.0,
        protected readonly float $min = 0.0,
        protected readonly float $max = 1.0,
    ) {
        $this->setValue($startValue);
        self::assert($this);
    }

    /**
     * @throws InvalidArgument
     */
    private static function assert(AFloatValue $value): void
    {
        match (true) {
            $value->min > $value->max => throw new InvalidArgument(
                sprintf(
                    'Max value should be greater than min value. Min: "%s", Max: "%s".',
                    $value->min,
                    $value->max,
                )
            ),
            $value->min === $value->max => throw new InvalidArgument(
                'Min and Max values cannot be equal.'
            ),
            default => null,
        };
    }

    public function getMin(): float
    {
        return $this->min;
    }

    public function getMax(): float
    {
        return $this->max;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    protected function setValue(float $value): void
    {
        $this->value = $value;
        $this->checkBounds();
    }

    protected function checkBounds(): void
    {
        if ($this->value > $this->max) {
            $this->value = $this->max;
        }
        if ($this->value < $this->min) {
            $this->value = $this->min;
        }
    }
}
