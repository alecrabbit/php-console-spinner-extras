<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette;

use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteStylePalette;
use Traversable;

final class CustomStylePalette extends AInfiniteStylePalette
{
    public function __construct(
        private readonly \Traversable $frames,
        private readonly ?int $frameWidth = null,
        IPaletteOptions $options = new PaletteOptions()
    ) {
        parent::__construct($options);
    }

    protected function ansi4StyleFrames(): Traversable
    {
        while (true) {
            yield from $this->frames;
        }
    }

    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        return new StyleFrame($element, $width ?? $this->frameWidth ?? 0);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return $this->options->getInterval();
    }


}
