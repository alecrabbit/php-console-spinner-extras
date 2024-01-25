<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Style;

use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteStylePalette;
use Traversable;

final class CustomStylePalette extends AInfiniteStylePalette
{
    public function __construct(
        Traversable $frames,
        private readonly ?int $frameWidth = null,
        IPaletteOptions $options = new PaletteOptions()
    ) {
        parent::__construct(frames: $frames, options: $options);
    }

    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        return new StyleFrame($element, $width ?? $this->frameWidth ?? 0);
    }
}
