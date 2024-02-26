<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use Traversable;

/**
 * @psalm-suppress UnusedClass
 */
final class MindBlown extends ACharPalette
{
    private const SPACE = "\u{3000} ";

    protected function sequence(): Traversable
    {
        yield from [
            '😊 ',
            '🙂 ',
            '😐 ',
            '😐 ',
            '😮 ',
            '😮 ',
            '😦 ',
            '😦 ',
            '😧 ',
            '😧 ',
            '🤯 ',
            '🤯 ',
            '💥 ',
            '✨ ',
            self::SPACE,
            self::SPACE,
            self::SPACE,
            self::SPACE,
            self::SPACE,
        ];
    }

    protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame
    {
        return new CharSequenceFrame($element, $width ?? 3);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 200;
    }
}
