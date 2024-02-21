<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use AlecRabbit\Spinner\Extras\Contract\IStyleFrame;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;

final readonly class StyleFrameRenderer implements IStyleFrameRenderer
{
    public function __construct(
        private IStyleRenderer $renderer,
    ) {
    }

    public function render(IStyleFrame $frame): IStyleSequenceFrame
    {
        return new StyleSequenceFrame(
            sequence: $this->renderer->render($frame->getStyle()),
            width: 0,
        );
    }
}
