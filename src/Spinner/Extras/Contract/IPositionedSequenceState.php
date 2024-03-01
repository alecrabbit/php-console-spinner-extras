<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\ISequenceState;

interface IPositionedSequenceState extends ISequenceState
{
    public function getPosition(): IPoint;
}
