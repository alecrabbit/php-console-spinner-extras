<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;
use AlecRabbit\Spinner\Extras\Palette\PaletteOptions;
use mysql_xdevapi\RowResult;
use RuntimeException;
use Traversable;

final class ProcedureCharPalette extends AInfiniteCharPalette
{
    public function __construct(
        private readonly IProcedure $procedure,
        IPaletteOptions $options = new PaletteOptions()
    ) {
        parent::__construct(frames: $this->wrapProcedure($procedure), options: $options);
    }

    private function wrapProcedure(IProcedure $procedure): Traversable
    {
        while (true) {
            yield $procedure->getFrame();
        }
    }

    public function unwrap(?IPaletteMode $mode = null): IPaletteTemplate
    {
        return new PaletteTemplate(
            $this->procedure,
            $this->options
        );
    }

    protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame
    {
        return new CharFrame($element, $width ?? 1);
    }
}
