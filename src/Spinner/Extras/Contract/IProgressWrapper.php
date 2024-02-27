<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Value\Contract\IFloatWrapper;

interface IProgressWrapper extends IFloatWrapper,
                                   IHasIsFinished,
                                   IHasIsStarted,
                                   IHasFinish,
                                   IHasStart
{
    public function getSteps(): int;

    /**
     * @throws InvalidArgument
     */
    public function advance(int $steps): void;
}
