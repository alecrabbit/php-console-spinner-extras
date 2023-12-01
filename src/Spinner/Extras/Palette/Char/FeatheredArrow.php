<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use Traversable;

final class FeatheredArrow extends ACharPalette
{
    protected function sequence(): Traversable
    {
        yield from [
            '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
            '➴', // BLACK-FEATHERED SOUTH EAST ARROW
            '➵', // BLACK-FEATHERED RIGHTWARDS ARROW
            '➶', // BLACK-FEATHERED NORTH EAST ARROW
            '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
            '➷', // HEAVY BLACK-FEATHERED SOUTH EAST ARROW
            '➸', // HEAVY BLACK-FEATHERED RIGHTWARDS ARROW
            '➹', // HEAVY BLACK-FEATHERED NORTH EAST ARROW
        ];
    }

    protected function createFrame(string $element): ICharFrame
    {
        return new CharFrame($element, 1);
    }

    protected function getInterval(): ?int
    {
        return 160;
    }
}
