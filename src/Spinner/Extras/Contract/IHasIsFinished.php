<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

interface IHasIsFinished
{
    public function isFinished(): bool;
}
