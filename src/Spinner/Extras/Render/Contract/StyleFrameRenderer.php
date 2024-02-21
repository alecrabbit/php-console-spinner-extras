<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Render\Contract;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Extras\Contract\IStyleFrame;

final readonly class StyleFrameRenderer implements IStyleFrameRenderer
{

    public function render(IStyleFrame $styleFrame): IStyleSequenceFrame
    {
        // TODO: Implement render() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
