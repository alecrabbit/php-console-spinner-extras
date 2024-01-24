<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleRenderer;

final readonly class StyleRendererFactory implements IStyleRendererFactory
{
    public function __construct(
        private IStyleToAnsiStringConverterFactory $converterFactory,
    ) {
    }

    public function create(): IStyleRenderer
    {
        return new StyleRenderer(
            converter: $this->converterFactory->create(),
        );
    }
}
