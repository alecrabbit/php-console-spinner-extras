<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Contract\IAnsiCode;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;

final class AnsiColorParser implements IAnsiColorParser
{
    public function __construct(
        protected IColorToAnsiCodeConverter $converter,
    ) {
    }

    public function parseColor(IColor|null|string $color): IAnsiCode
    {
        if ($color === '' || $color === null) {
            return new AnsiCode();
        }

        return $this->converter->convert($color);
    }
}
