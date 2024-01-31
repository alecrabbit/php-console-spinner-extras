<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Contract\IStylingFrame;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Revolver\A\AFrameRevolver;
use Traversable;

final class StyleFrameRevolver extends AFrameRevolver
{
    public function __construct(
        Traversable $frames,
        IInterval $interval,
        ITolerance $tolerance,
        private readonly IStyleRenderer $styleRenderer,
    ) {
        parent::__construct($frames, $interval, $tolerance);
    }

    protected function current(): IStyleFrame
    {
        if ($this->current instanceof IStylingFrame) {
            return $this->render($this->current);
        }

        return $this->current;
    }

    private function render(IStylingFrame $frame): IStyleFrame
    {
        return new StyleFrame(
            sequence: $this->styleRenderer->render($frame->getStyle()),
            width: 0,
        );
    }
}
