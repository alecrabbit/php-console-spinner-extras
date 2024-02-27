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
 * @psalm-suppress UnusedClass
 */
final class MindBlown extends ACharPalette
{
    private const SPACE = "\u{3000} ";

    public function __construct(
        IPaletteOptions $options = new PaletteOptions(interval: 200),
        int $index = 0,
    ) {
        parent::__construct(
            new \ArrayObject(
                [
                    new CharSequenceFrame('😊 ', 3),
                    new CharSequenceFrame('🙂 ', 3),
                    new CharSequenceFrame('😐 ', 3),
                    new CharSequenceFrame('😐 ', 3),
                    new CharSequenceFrame('😮 ', 3),
                    new CharSequenceFrame('😮 ', 3),
                    new CharSequenceFrame('😦 ', 3),
                    new CharSequenceFrame('😦 ', 3),
                    new CharSequenceFrame('😧 ', 3),
                    new CharSequenceFrame('😧 ', 3),
                    new CharSequenceFrame('🤯 ', 3),
                    new CharSequenceFrame('🤯 ', 3),
                    new CharSequenceFrame('💥 ', 3),
                    new CharSequenceFrame('✨ ', 3),
                    new CharSequenceFrame(self::SPACE, 3),
                    new CharSequenceFrame(self::SPACE, 3),
                    new CharSequenceFrame(self::SPACE, 3),
                    new CharSequenceFrame(self::SPACE, 3),
                    new CharSequenceFrame(self::SPACE, 3),
                ],
            ),
            $options,
            $index
        );
    }
}
