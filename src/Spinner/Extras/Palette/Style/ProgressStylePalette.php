<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Style;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteStylePalette;

use AlecRabbit\Spinner\Extras\Palette\ProgressPaletteOptions;

final class ProgressStylePalette extends AInfiniteStylePalette
{
    public function __construct(
        IProcedure $procedure,
        IPaletteOptions $options = new ProgressPaletteOptions()
    ) {
        parent::__construct(frames: $this->wrapProcedure($procedure), options: $options);
    }

    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        return new StyleFrame($element, $width ?? 0);
    }

    private function wrapProcedure(IProcedure $procedure): \Traversable
    {
        while (true) {
            yield $procedure->getFrame();
        }
    }
}
