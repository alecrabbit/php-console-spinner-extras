<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

interface IFloatValue
{
    public function getValue(): float;

    public function setValue(float $value): void;

    public function getMin(): float;

    public function getMax(): float;
}
