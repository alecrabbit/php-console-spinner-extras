<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

interface IStylingFrame extends IStyleFrame
{
    public function getStyle(): IStyle;
}
