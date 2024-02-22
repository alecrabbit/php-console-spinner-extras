<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Contract\IStyleFrame;
use AlecRabbit\Spinner\Extras\Frame\StyleFrame;
use AlecRabbit\Spinner\Extras\Procedure\A\AProcedure;

final class Red extends AProcedure implements IStylePalette
{
    private IStyleFrame $frame;

    public function __construct(
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct(options: $options);

        $this->frame = new StyleFrame(
            style: new Style(fgColor: 'red'),
        );
    }

    public function getFrame(?float $dt = null): IStyleFrame
    {
        return $this->frame;
    }
}
