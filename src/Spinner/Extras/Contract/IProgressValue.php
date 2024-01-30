<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;

interface IProgressValue extends IFloatValue, IHasIsFinished
{
    public function getSteps(): int;

    /**
     * @throws InvalidArgument
     */
    public function advance(int $steps): void;

    public function finish(): void;
}
