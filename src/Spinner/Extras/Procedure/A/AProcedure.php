<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;

abstract class AProcedure implements IProcedure, IPalette
{
    public function __construct(
        protected readonly IPaletteOptions $options = new PaletteOptions(),
    ) {
    }

    abstract public function getFrame(?float $dt = null): IFrame;

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }
}
