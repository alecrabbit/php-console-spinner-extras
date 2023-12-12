<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleFrameRenderer;

/**
 * @deprecated
 */
final class StyleFrameRendererFactory implements IStyleFrameRendererFactory
{
    public function __construct(
        protected IStyleFrameFactory $frameFactory,
        protected IStyleRendererFactory $styleRendererFactory,
        protected StylingMethodOption $styleMode,
    ) {
    }

    public function create(StylingMethodOption $mode): IStyleFrameRenderer
    {
        $styleMode = $this->styleMode->lowest($mode);
        return
            new StyleFrameRenderer(
                frameFactory: $this->frameFactory,
                styleRenderer: $this->styleRendererFactory->create($styleMode),
                styleMode: $styleMode,
            );
    }
}
