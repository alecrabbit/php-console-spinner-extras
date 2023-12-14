<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\A;

use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use Traversable;

abstract class AInfiniteStylePalette extends AStylePalette implements IInfinitePalette
{
    public function __construct(
        private readonly Traversable $frames,
        IPaletteOptions $options = new PaletteOptions()
    ) {
        self::assertOptions($options);
        parent::__construct($options);
    }

    private static function assertOptions(IPaletteOptions $options): void
    {
        // FIXME (2023-12-14 14:48) [Alec Rabbit]: options with reversed = true is not supported
    }

    protected function noStyleFrames(): Traversable
    {
        while (true) {
            yield from parent::noStyleFrames();
        }
    }

    protected function ansi4StyleFrames(): Traversable
    {
        while (true) {
            yield from $this->frames;
        }
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return $this->options->getInterval();
    }
}