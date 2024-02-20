<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IHasSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Contract\IStyleFrame;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Revolver\A\AFrameRevolver;
use Traversable;

final class StyleFrameRevolver extends AFrameRevolver
{
    public function __construct(
        IHasSequenceFrame $frames,
        IInterval $interval,
        private readonly IStyleRenderer $styleRenderer,
    ) {
        parent::__construct($frames, $interval);
    }

    protected function current(): IStyleSequenceFrame
    {
        $frame = $this->frames->current();

        if ($frame instanceof IStyleFrame) {
            return $this->render($frame);
        }

        return $frame;
    }

    private function render(IStyleFrame $frame): IStyleSequenceFrame
    {
        return new StyleFrame(
            sequence: $this->styleRenderer->render($frame->getStyle()),
            width: 0,
        );
    }
}
