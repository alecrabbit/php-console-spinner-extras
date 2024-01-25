<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

final readonly class Labels implements ILabels
{
    public function __construct(
        private string $year = 'y',
        private string $month = 'm',
        private string $day = 'd',
        private string $hour = 'h',
        private string $minute = 'min',
        private string $second = 'sec',
    ) {
    }

    public function year(): string
    {
        return $this->year;
    }

    public function month(): string
    {
        return $this->month;
    }

    public function day(): string
    {
        return $this->day;
    }

    public function hour(): string
    {
        return $this->hour;
    }

    public function minute(): string
    {
        return $this->minute;
    }

    public function second(): string
    {
        return $this->second;
    }
}
