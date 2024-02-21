<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

interface IStyleFrame extends IFrame
{
    public function getStyle(): IStyle;
}
