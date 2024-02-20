<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Contract\ISequenceFrame;

abstract class AProcedure implements IProcedure
{
    abstract public function getFrame(?float $dt = null): IFrame;
}
