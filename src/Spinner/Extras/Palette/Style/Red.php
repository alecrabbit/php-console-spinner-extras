<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Style;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use Traversable;

final class Red extends AStylePalette {
    protected function ansi4StyleFrames(): Traversable
    {
        yield from [
            $this->createFrame("\e[31m%s\e[39m"),
        ];
    }

    protected function ansi8StyleFrames(): Traversable
    {
        return $this->ansi4StyleFrames();
    }

    protected function ansi24StyleFrames(): Traversable
    {
        return $this->ansi4StyleFrames();
    }

    protected function getInterval(StylingMethodMode $stylingMode): ?int
    {
        return null; // due to single style frame
    }
}
