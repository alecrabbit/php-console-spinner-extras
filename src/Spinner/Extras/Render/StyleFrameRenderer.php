<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;

/**
 * @deprecated
 */
final readonly class StyleFrameRenderer implements IStyleFrameRenderer
{
    public function __construct(
        private IStyleFrameFactory $frameFactory,
        private IStyleRenderer $styleRenderer,
        private StylingMethodOption $styleMode,
    ) {
    }

    public function render(IStyle $style): IFrame
    {
        if ($this->styleMode === StylingMethodOption::NONE) {
            return $this->frameFactory->create('%s', 0);
        }
        return $this->createFrameFromStyle($style);
    }

    private function createFrameFromStyle(IStyle $style): IFrame
    {
        if ($style->isEmpty()) {
            return $this->frameFactory->create($style->getFormat(), $style->getWidth());
        }

        return $this->frameFactory->create(
            $this->styleRenderer->render($style),
            $style->getWidth()
        );
    }
}
