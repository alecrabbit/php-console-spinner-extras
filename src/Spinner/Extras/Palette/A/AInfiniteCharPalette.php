<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\A;

use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use Traversable;

abstract class AInfiniteCharPalette extends ACharPalette implements IInfinitePalette
{
    public function __construct(
        protected readonly Traversable $frames,
        IPaletteOptions $options = new PaletteOptions()
    ) {
        parent::__construct($options);
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
