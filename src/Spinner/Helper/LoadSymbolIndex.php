<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Extras\Value\ILoadValue;

final class LoadSymbolIndex extends ASubject implements ILoadSymbolIndex
{
    private int $inter;


    public function __construct(
        private readonly ILoadValue $loadValue,
        private int $current = 0,
        private bool $even = true,
        private readonly IFloatToIndex $floatToIndex = new FloatToIndex(),
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);

        $this->inter = $this->current;
        $this->loadValue->attach($this);
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->loadValue) {
            /** @var ILoadValue $subject */
            $this->add($subject->getValue());
        }
    }

    protected function add(float $input): void
    {
        $this->inter &= 0b00001111;
        $this->inter <<= 4;

        $v = $this->floatToIndex->get($input);

        $this->inter |= $v;

        $this->even = !$this->even;

        if ($this->even) {
            $this->current = $this->inter;
            $this->notify();
        }
    }

    public function get(): int
    {
        return $this->current;
    }

    public function getLoadValue(): ILoadValue
    {
        return $this->loadValue;
    }
}
