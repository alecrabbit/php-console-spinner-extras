<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Util\Color;

use function is_string;

final readonly class HexColorNormalizer implements IHexColorNormalizer
{
    public function normalize(IColor|string $color): IHexColor
    {
        if (is_string($color)) {
            $color = Color::from($color);
        }

        return $color->to(IHexColor::class);
    }
}
