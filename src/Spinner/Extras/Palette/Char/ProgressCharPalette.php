<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;
use AlecRabbit\Spinner\Extras\Palette\Contract\ITraversableWrapper;
use AlecRabbit\Spinner\Extras\Palette\ProgressPaletteOptions;

final class ProgressCharPalette extends AInfiniteCharPalette
{
    public function __construct(
        ITraversableWrapper $palette,
        IPaletteOptions $options = new ProgressPaletteOptions()
    ) {
        parent::__construct(frames: $palette(), options: $options);
    }

    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? 1);
    }
}
