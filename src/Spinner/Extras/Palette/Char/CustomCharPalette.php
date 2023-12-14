<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;
use Traversable;

final class CustomCharPalette extends AInfiniteCharPalette
{
    public function __construct(
        Traversable $frames,
        private readonly ?int $frameWidth = null,
        IPaletteOptions $options = new PaletteOptions()
    ) {
        parent::__construct(frames: $frames, options: $options);
    }

    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? $this->frameWidth ?? 1);
    }

}
