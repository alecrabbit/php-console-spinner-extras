<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\A;

use AlecRabbit\Spinner\Core\A\AValue;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\IFloatValue;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;

abstract class AProgressValue extends AFloatValue implements IProgressValue
{
    protected bool $finished = false;
    protected float $stepValue;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        float $startValue = 0.0,
        float $min = 0.0,
        float $max = 1.0,
        protected readonly int $steps = 100,
        protected readonly bool $autoFinish = true,
    ) {
        parent::__construct($startValue, $min, $max);
        $this->stepValue = ($this->max - $this->min) / $this->steps;
    }

    protected function assert(): void
    {
        parent::assert();
        match (true) {
            0 > $this->steps || 0 === $this->steps =>
            throw new InvalidArgumentException(
                sprintf(
                    'Steps should be greater than 0. Steps: "%s".',
                    $this->steps,
                )
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

    /** @inheritdoc */
    public function advance(int $steps = 1): void
    {
        if ($this->finished) {
            return;
        }

        $this->value += $steps * $this->stepValue;
        $this->checkBounds();
        $this->autoFinish();
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

    protected function autoFinish(): void
    {
        if ($this->autoFinish && $this->value === $this->max) {
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
