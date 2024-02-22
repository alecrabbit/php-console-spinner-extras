<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use Traversable;

/**
 * @codeCoverageIgnore
 * @psalm-suppress UnusedClass
 */
final class Dice extends ACharPalette
{
    public function __construct(
        IPaletteOptions $options = new PaletteOptions(interval: 80),
        int $index = 0,
    ) {
        parent::__construct(
            new \ArrayObject(
                [
                    new CharSequenceFrame('⚀', 1),
                    new CharSequenceFrame('⚁', 1),
                    new CharSequenceFrame('⚂', 1),
                    new CharSequenceFrame('⚃', 1),
                    new CharSequenceFrame('⚄', 1),
                    new CharSequenceFrame('⚅', 1),
                ],
            ),
            $options,
            $index
        );
    }
}
