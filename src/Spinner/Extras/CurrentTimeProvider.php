<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use DateTimeImmutable;

final readonly class CurrentTimeProvider implements ICurrentTimeProvider
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
