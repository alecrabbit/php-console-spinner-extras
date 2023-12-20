<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Color\A\AColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;

final class SimpleHexColorToAnsiCodeConverter extends AColorToAnsiCodeConverter implements IHexColorToAnsiCodeConverter
{
    public function convert(string $color): string
    {
        $color = $this->normalize($color);

        return match ($this->styleMode) {
            StylingMethodMode::ANSI4 => $this->convert4($color),
            StylingMethodMode::ANSI8 => $this->convert8($color),
            default => $this->convertHexColorToAnsiColorCode($color),
        };
    }

    /**
     * @throws InvalidArgument
     */
    protected function convertHexColorToAnsiColorCode(string $hexColor): string
    {
        $color = $this->toInt($hexColor);

        $r = ($color >> 16) & 255;
        $g = ($color >> 8) & 255;
        $b = $color & 255;

        return match ($this->styleMode) {
            StylingMethodMode::ANSI24 => sprintf('8;2;%d;%d;%d', $r, $g, $b),
            default => throw new InvalidArgument(
                sprintf(
                    'Failed to convert color "%s" in mode "%s".',
                    $hexColor,
                    $this->styleMode->name,
                )
            )
        };
    }
}
