<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use ArrayObject;
use Traversable;

/**
 * @psalm-suppress UnusedClass
 */
final class RainyWeather extends ACharPalette
{
    public function __construct(
        IPaletteOptions $options = new PaletteOptions(interval: 80),
        int $index = 0,
    ) {
        parent::__construct(
            new ArrayObject(
                [
                    new CharSequenceFrame('🌤 ', 2),
                    new CharSequenceFrame('🌤 ', 2),
                    new CharSequenceFrame('🌤 ', 2),
                    new CharSequenceFrame('🌥 ', 2),
                    new CharSequenceFrame('🌧 ', 2),
                    new CharSequenceFrame('🌨 ', 2),
                    new CharSequenceFrame('🌧 ', 2),
                    new CharSequenceFrame('🌨 ', 2),
                    new CharSequenceFrame('🌧 ', 2),
                    new CharSequenceFrame('🌨 ', 2),
                    new CharSequenceFrame('🌧 ', 2),
                    new CharSequenceFrame('🌨 ', 2),
                    new CharSequenceFrame('🌧 ', 2),
                    new CharSequenceFrame('🌨 ', 2),
                    new CharSequenceFrame('🌧 ', 2),
                    new CharSequenceFrame('🌥 ', 2),
                    new CharSequenceFrame('🌤 ', 2),
                    new CharSequenceFrame('🌤 ', 2),
                    new CharSequenceFrame('🌤 ', 2),
                ],
            ),
            $options,
            $index
        );
    }
}
