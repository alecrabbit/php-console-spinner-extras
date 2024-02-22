<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use Traversable;

/**
 * @codeCoverageIgnore
 * @psalm-suppress UnusedClass
 */
final class FistBump extends ACharPalette
{
    private const SPACE = "\u{3000} ";

    protected function sequence(): Traversable
    {
        yield from [
            "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
            "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
            "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
            "\u{3000}🤜\u{3000}\u{3000}🤛\u{3000}\u{3000} ",
            "\u{3000}\u{3000}🤜🤛\u{3000}\u{3000}\u{3000} ",
            "\u{3000}\u{3000}🤜✨🤛\u{3000}\u{3000} ",
            "\u{3000}🤜\u{3000}\u{3000}🤛\u{3000}\u{3000} ",
            "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
            "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
            "🤜\u{3000}\u{3000}\u{3000}\u{3000}🤛\u{3000} ",
        ];
    }

    protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame
    {
        return new CharSequenceFrame($element, $width ?? 15);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 80;
    }
}
