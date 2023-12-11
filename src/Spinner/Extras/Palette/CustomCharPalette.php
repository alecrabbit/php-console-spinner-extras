<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;
use Traversable;

final class CustomCharPalette extends AInfiniteCharPalette
{
    public function __construct(
        private readonly \Traversable $frames,
        private readonly ?int $frameWidth = null,
        IPaletteOptions $options = new PaletteOptions()
    ) {
        parent::__construct($options);
    }

    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? $this->frameWidth ?? 1);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return $this->options->getInterval();
    }

    protected function sequence(): Traversable
    {
        while (true) {
            yield from $this->frames;
        }
    }
}
