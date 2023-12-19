<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Style;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteStylePalette;
use AlecRabbit\Spinner\Extras\Palette\PaletteOptions;
use Traversable;

final class ProcedureStylePalette extends AInfiniteStylePalette
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

    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        /** @var IStyleFrame|string $item */
        foreach ($this->getFrames($mode) as $item) {
            yield $this->createStyleFrame($item);
        }
    }

    protected function createStyleFrame(mixed $element, ?int $width = null): IStyleFrame
    {
        if ($element instanceof IStyleFrame) {
            return $element;
        }
        return new StyleFrame($element, $width ?? 0);
    }

    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        throw new LogicException(sprintf('%s() should not be called', __METHOD__));
    }
}
