<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final class LoadValue extends ASubject implements ILoadValue
{
    private float $value;

    /**
     * @throws InvalidArgument
     */
    public function __construct(
        float $startValue = 0.0,
        private readonly float $min = 0.0,
        private readonly float $max = 1.0,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        
        $this->setValue($startValue);
        self::assert($this);
    }

    /**
     * @throws InvalidArgument
     */
    private static function assert(self $value): void
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

    public function setLoad(float $load): void
    {
        $this->setValue($load);
        $this->notify();
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

    private function setValue(float $value): void
    {
        $this->value = $value;
        $this->checkBounds();
    }

    private function checkBounds(): void
    {
        if ($this->value > $this->max) {
            $this->value = $this->max;
        }
        if ($this->value < $this->min) {
            $this->value = $this->min;
        }
    }
}
