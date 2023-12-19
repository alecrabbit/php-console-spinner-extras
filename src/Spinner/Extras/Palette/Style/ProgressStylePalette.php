<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Style;

use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteStylePalette;
use AlecRabbit\Spinner\Extras\Palette\Contract\ITraversableWrapper;
use AlecRabbit\Spinner\Extras\Palette\ProgressPaletteOptions;

final class ProgressStylePalette extends AInfiniteStylePalette
{
    public function __construct(
        ITraversableWrapper $palette,
        IPaletteOptions $options = new ProgressPaletteOptions()
    ) {
        parent::__construct(frames: $palette(), options: $options);
    }

    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        return new StyleFrame($element, $width ?? 0);
    }
}
