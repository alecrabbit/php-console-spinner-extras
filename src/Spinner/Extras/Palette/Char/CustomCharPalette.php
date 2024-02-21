<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;
use RuntimeException;
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

    

    protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame
    {
        return new CharSequenceFrame($element, $width ?? $this->frameWidth ?? 1);
    }
}
