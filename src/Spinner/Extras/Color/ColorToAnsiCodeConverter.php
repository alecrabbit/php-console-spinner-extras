<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Contract\IAnsiCode;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;

final readonly class ColorToAnsiCodeConverter implements IColorToAnsiCodeConverter
{
    public function __construct(
        private StylingMethodMode $mode,
    ) {
    }

    public function convert(IColor|string $color): IAnsiCode
    {
        $color = $this->normalize($color);

        return $this->doConvert($color);
    }

    private function normalize(IColor|string $color): IHexColor
    {
        if (\is_string($color)) {
            $color = Color::from($color);
        }

        return $color->to(IHexColor::class);
    }

    private function doConvert(IHexColor $color): IAnsiCode
    {
        return new AnsiCode(8, 2, 198, 198, 198);
    }
}
