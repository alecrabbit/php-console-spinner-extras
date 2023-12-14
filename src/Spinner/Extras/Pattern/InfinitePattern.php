<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Pattern;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Extras\Pattern\Contract\IInfinitePattern;
use Traversable;

final readonly class InfinitePattern implements IInfinitePattern
{
    /**
     * @param IInterval $interval
     * @param Traversable<IFrame> $frames
     */
    public function __construct(
        private IInterval $interval,
        private Traversable $frames,
    ) {
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    /** @inheritDoc */
    public function getFrames(): Traversable
    {
        return $this->frames;
    }
}
