<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IStyleFrame;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;

final readonly class StyleFrameTransformer implements IStyleFrameTransformer
{
    public function __construct(
        private IStyleFrameRenderer $styleFrameRenderer,
    ) {
    }

    public function transform(IFrame $frame): IStyleSequenceFrame
    {
        if ($frame instanceof IStyleSequenceFrame) {
            return $frame;
        }

        if ($frame instanceof IStyleFrame) {
            return $this->styleFrameRenderer->render($frame);
        }

        throw new InvalidArgument(
            sprintf(
                'Non-transformable frame type "%s".',
                get_class($frame),
            )
        );
    }

}
