<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Frame\StyleFrame;
use AlecRabbit\Spinner\Extras\Procedure\A\AProcedure;

final class Red extends AProcedure implements IStylePalette
{
    public function getFrame(?float $dt = null): IFrame
    {
        return new StyleFrame(
            style: new Style(fgColor: 'red'),
        );
    }
}
