<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\PaletteOptions;

abstract class AProcedure implements IProcedure, IPalette
{
    abstract public function getFrame(?float $dt = null): IFrame;

    public function getOptions(): IPaletteOptions
    {
        return new PaletteOptions(); // FIXME (2024-02-21 12:52) [Alec Rabbit]: stub! [17d7bea2-bc3a-4a5e-821c-062a65b35a5f]
    }
}
