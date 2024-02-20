<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Style;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
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

    public function unwrap(?IPaletteMode $mode = null): IPaletteTemplate
    {
        // TODO: Implement unwrap() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }

    protected function createFrame(string $element, ?int $width = null): IStyleSequenceFrame
    {
        return new StyleFrame($element, $width ?? $this->frameWidth ?? 0);
    }
}
