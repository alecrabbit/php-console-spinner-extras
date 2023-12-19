<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;

use AlecRabbit\Spinner\Extras\Palette\PaletteOptions;

final class ProcedureCharPalette extends AInfiniteCharPalette
{
    public function __construct(
        IProcedure $procedure,
        IPaletteOptions $options = new PaletteOptions()
    ) {

            parent::__construct(frames: $this->wrapProcedure($procedure), options: $options);

    }

    private function wrapProcedure(IProcedure $procedure): \Traversable
    {
        while (true) {
            yield $procedure->getFrame();
        }
    }

    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? 1);
    }
}
