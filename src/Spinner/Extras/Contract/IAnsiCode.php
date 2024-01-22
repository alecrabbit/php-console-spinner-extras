<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use Stringable;

interface IAnsiCode extends Stringable
{
    public function toString(): string;

    public function isEmpty(): bool;
}
