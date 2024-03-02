<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleRenderer;

final readonly class StyleRendererFactory implements IStyleRendererFactory, IInvokable
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

    public function __invoke(): IStyleRenderer
    {
        return $this->create();
    }
}
