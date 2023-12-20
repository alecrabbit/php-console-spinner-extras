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
        private IStyleRenderer $styleRenderer,
    ) {
        parent::__construct($frames, $interval, $tolerance);
    }

    protected function current(): IStyleFrame
    {
        $frame = $this->frames->current();
        if ($frame instanceof IStylingFrame) {
            $frame = new StyleFrame(
                sequence: $this->styleRenderer->render($frame->getStyle()),
                width: 0
            );
        }
        return $frame;
    }

//    private function render(IStylingFrame $frame): IFrame
//    {
//        dump($frame);
//        // TODO (2023-12-19 16:17) [Alec Rabbit]: call style renderer
//        return $frame;
//    }
}
