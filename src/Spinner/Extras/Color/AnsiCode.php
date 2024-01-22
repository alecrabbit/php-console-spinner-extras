<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Contract\IAnsiCode;

final readonly class AnsiCode implements IAnsiCode
{
    private array $codes;

    public function __construct(
        int ...$code,
    ) {
        $this->codes = $code;
    }

    public function __toString(): string
    {
        return \implode(';', $this->codes);
    }

    public function toString(): string
    {
        return $this->__toString();
    }
}
