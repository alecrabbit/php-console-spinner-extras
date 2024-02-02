<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;


use AlecRabbit\Spinner\Extras\Color\A\AAnsiCode;
use AlecRabbit\Spinner\Extras\Contract\IAnsiCode;

final readonly class AnsiCode  implements IAnsiCode
{
    private array $codes;
    private bool $empty;

    public function __construct(
        int ...$code,
    ) {
        $this->codes = $code;
        $this->empty = count($code) === 0;
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        return implode(';', $this->codes);
    }

    public function isEmpty(): bool
    {
        return $this->empty;
    }
}
