<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use DateTimeImmutable;

interface ICurrentTimeProvider
{
    public function now(): DateTimeImmutable;
}
