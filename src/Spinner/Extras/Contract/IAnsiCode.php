<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

interface IAnsiCode extends \Stringable
{
    public function toString(): string;
}
