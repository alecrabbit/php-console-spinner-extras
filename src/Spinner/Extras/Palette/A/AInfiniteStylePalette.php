<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\A;

use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use Traversable;

abstract class AInfiniteStylePalette extends AStylePalette implements IInfinitePalette
{
    protected function noStyleFrames(): Traversable
    {
        while (true) {
            yield from parent::noStyleFrames();
        }
    }
}
