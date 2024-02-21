<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Style;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteStylePalette;
use RuntimeException;
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

    

    protected function createFrame(string $element, ?int $width = null): IStyleSequenceFrame
    {
        return new StyleSequenceFrame($element, $width ?? $this->frameWidth ?? 0);
    }
}
