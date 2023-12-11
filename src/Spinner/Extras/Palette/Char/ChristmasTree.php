<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use Traversable;

/**
 * @codeCoverageIgnore
 * @psalm-suppress UnusedClass
 */
final class ChristmasTree extends ACharPalette
{
    protected function sequence(): Traversable
    {
        yield from  ['🌲', '🎄'];
    }

    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? 2);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 500;
    }
}
