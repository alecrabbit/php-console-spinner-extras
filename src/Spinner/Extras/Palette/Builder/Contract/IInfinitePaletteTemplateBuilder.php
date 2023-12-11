<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Builder\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Builder\Contract\IPaletteTemplateBuilder;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use Traversable;

interface IInfinitePaletteTemplateBuilder extends IPaletteTemplateBuilder
{
    /**
     * @param Traversable<IFrame> $entries
     */
    public function withEntries(Traversable $entries): IInfinitePaletteTemplateBuilder;

    public function withOptions(IPaletteOptions $options): IInfinitePaletteTemplateBuilder;
}
