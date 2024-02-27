<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

interface IHasIsStarted
{
    public function isStarted(): bool;
}
