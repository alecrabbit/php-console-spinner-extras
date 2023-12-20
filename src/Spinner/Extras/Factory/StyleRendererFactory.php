<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleRenderer;

final class StyleRendererFactory implements IStyleRendererFactory
{
    public function __construct(
        protected IStyleToAnsiStringConverterFactory $converterFactory,
    ) {
    }

    public function create(StylingMethodMode $styleMode): IStyleRenderer
    {
        return new StyleRenderer(
            converter: $this->converterFactory->create($styleMode),
        );
    }
}
