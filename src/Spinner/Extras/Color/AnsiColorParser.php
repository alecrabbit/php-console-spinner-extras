<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;

final class AnsiColorParser implements IAnsiColorParser
{
    public function __construct(
        protected IColorToAnsiCodeConverter $converter,
    ) {
    }

    public function parseColor(IColor|null|string $color): string
    {
        if ($color === '' || $color === null) {
            return '';
        }

        return $this->converter->convert($color)->toString();
    }
}
