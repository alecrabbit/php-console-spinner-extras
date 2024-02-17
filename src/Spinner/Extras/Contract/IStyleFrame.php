<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Core\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

interface IStyleFrame extends IStyleSequenceFrame
{
    public function getStyle(): IStyle;
}
