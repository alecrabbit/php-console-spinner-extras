<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;

final readonly class ProgressPaletteOptions implements IPaletteOptions
{
    public function __construct(
        private ?int $interval = 200,
        private bool $reversed = false,
    ) {
    }

    public function isReversed(): bool
    {
        return $this->reversed;
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }
}
