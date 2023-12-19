<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;

interface IProgressValue extends IFloatValue
{
    public function getSteps(): int;

    /**
     * @throws InvalidArgument
     */
    public function advance(int $steps): void;

    public function finish(): void;

    public function isFinished(bool $useThreshold = false): bool; // FIXME (2023-12-19 16:26) [Alec Rabbit]: remove param $useThreshold - move feature elsewhere
}
