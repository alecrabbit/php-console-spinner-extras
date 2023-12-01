<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
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

    protected function createFrame(string $element): ICharFrame
    {
        return new CharFrame($element, 15);
    }

    protected function getInterval(): ?int
    {
        return 80;
    }
}
