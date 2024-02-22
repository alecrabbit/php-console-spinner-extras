<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

interface ILabels
{
    public function year(): string;

    public function month(): string;

    public function day(): string;

    public function hour(): string;

    public function minute(): string;

    public function second(): string;
}
