<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Contract\IHexColorNormalizer;
use AlecRabbit\Spinner\Extras\Contract\IAnsiCode;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;

final readonly class ColorToAnsiCodeConverter implements IColorToAnsiCodeConverter
{
    public function __construct(
        private IHexColorNormalizer $hexColorNormalizer,
        private IColorCodesGetter $colorCodesGetter,
    ) {
    }

    public function convert(IColor|string $color): IAnsiCode
    {
        $color = $this->hexColorNormalizer->normalize($color);

        return new AnsiCode(
            ...$this->colorCodesGetter->getCodes($color->getRed(), $color->getGreen(), $color->getBlue())
        );
    }
}
