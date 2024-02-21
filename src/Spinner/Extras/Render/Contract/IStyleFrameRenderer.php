<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render\Contract;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Extras\Contract\IStyleFrame;

interface IStyleFrameRenderer
{
    public function render(IStyleFrame $styleFrame): IStyleSequenceFrame;
}
