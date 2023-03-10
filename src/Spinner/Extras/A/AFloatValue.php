<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\A;

use AlecRabbit\Spinner\Core\A\AValue;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\IFloatValue;

abstract class AFloatValue extends AValue implements IFloatValue
{
    public function __construct(
        float $startValue = 0.0,
        protected readonly float $min = 0.0,
        protected readonly float $max = 1.0,
    ) {
        $this->setValue($startValue);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function assert(): void
    {
        match (true) {
            $this->value->min > $this->value->max =>
            throw new InvalidArgumentException(
                sprintf(
                    'Max value should be greater than min value. Min: "%s", Max: "%s".',
                    $this->value->min,
                    $this->value->max,
                )
            ),
            $this->value->min === $this->value->max =>
            throw new InvalidArgumentException(
                'Min and Max values cannot be equal.'
            ),
            default => null,
        };
    }

    /** @inheritdoc */
    public function setValue($value): void
    {
        parent::setValue($value);
        $this->checkBounds();
    }

    public function getMin(): float
    {
        return $this->min;
    }

    public function getMax(): float
    {
        return $this->max;
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

    protected static function assertValue(mixed $value): void
    {
        if(!\is_float($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Value should be float. Value: "%s".',
                    $value,
                )
            );
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
