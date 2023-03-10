<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Core\Contract\IValue;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IFloatValue extends IValue
{
    public function getValue(): float;

    /**
     * @param float $value
     */
    public function setValue($value): void;

    public function getMin(): float;

    public function getMax(): float;

    public function getSteps(): int;

    /**
     * @throws InvalidArgumentException
     */
    public function advance(int $steps): void;

    public function finish(): void;

    public function isFinished(): bool;
}
