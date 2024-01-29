<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\A\ASubject;

final class LoadValue extends ASubject implements ILoadValue
{
    private int $inter;
    
    public function __construct(
        private int $current = 0,
        private bool $even = true,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        
        $this->inter = $this->current;
    }

    public function get(): int
    {
        return $this->current;
    }

    public function add(float $input): void
    {
        $this->inter &= 0b00001111;
        $this->inter <<= 4;

        $v = match (true) {
            $input < 0.125 => 0,
            $input < 0.375 => 1,
            $input < 0.625 => 3,
            $input < 0.875 => 7,
            default => 15,
        };

        $this->inter |= $v;
        
        $this->even = !$this->even;

        if ($this->even) {
            $this->current = $this->inter;
            $this->notify();
        }
    }
}
