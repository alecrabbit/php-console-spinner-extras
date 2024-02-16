<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Style;

use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\StyleFrame;
use Traversable;

final class Red extends AStylePalette
{
    protected function ansi4StyleFrames(): Traversable
    {
        yield from [
            $this->createFrame("\e[31m%s\e[39m"),
        ];
    }

    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        return new StyleFrame($element, $width ?? 0);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return null;
    }

    public function unwrap(?IPaletteMode $mode = null): IPaletteTemplate
    {
        // TODO: Implement unwrap() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
