<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;
use AlecRabbit\Spinner\Extras\Palette\Contract\IInvokablePalette;

final class ProgressCharPalette extends AInfiniteCharPalette
{
    public function __construct(
        IInvokablePalette $palette,
        IPaletteOptions $options = new PaletteOptions()
    ) {
        parent::__construct(frames: $palette(), options: $options);
    }

    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? 1);
    }
}
