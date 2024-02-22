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
final class HalfCircle extends ACharPalette
{


    protected function sequence(): Traversable
    {
        yield from ['◐', '◓', '◑', '◒'];
    }

    protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame
    {
        return new CharSequenceFrame($element, $width ?? 1);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 160;
    }
}
