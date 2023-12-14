<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Factory;

use AlecRabbit\Spinner\Core\Palette\Builder\Contract\IPaletteTemplateBuilder;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteTemplateFactory;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use AlecRabbit\Spinner\Extras\Palette\Contract\Builder\IInfinitePaletteTemplateBuilder;

final readonly class PaletteTemplateFactory implements IPaletteTemplateFactory
{
    public function __construct(
        private IPaletteTemplateBuilder $builder,
        private IInfinitePaletteTemplateBuilder $infiniteBuilder,
        private IPaletteModeFactory $paletteModeFactory,
    ) {
    }

    public function create(IPalette $palette): IPaletteTemplate
    {
        $mode = $this->paletteModeFactory->create();

        if ($palette instanceof IInfinitePalette) {
            return $this->infiniteBuilder
                ->withEntries($palette->getEntries($mode))
                ->withOptions($palette->getOptions($mode))
                ->build()
            ;
        }

        return $this->builder
            ->withEntries($palette->getEntries($mode))
            ->withOptions($palette->getOptions($mode))
            ->build()
        ;
    }
}
