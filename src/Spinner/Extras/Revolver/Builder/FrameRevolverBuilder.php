<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Revolver\FrameRevolver;
use Traversable;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class FrameRevolverBuilder implements IFrameRevolverBuilder
{
    /** @var Traversable<IFrame>|null  */
    private ?Traversable $frames = null;
    private ?IInterval $interval = null;
    private ?ITolerance $tolerance = null;

    public function build(): IFrameRevolver
    {
        $this->validate();

        return new FrameRevolver(
            $this->frames,
            $this->interval,
            $this->tolerance,
        );
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->frames === null => throw new LogicException('Frame collection is not set.'),
            $this->interval === null => throw new LogicException('Interval is not set.'),
            $this->tolerance === null => throw new LogicException('Tolerance is not set.'),
            default => null,
        };
    }

    /** @inheritDoc */
    public function withFrames(Traversable $frames): IFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->frames = $frames;
        return $clone;
    }

    public function withInterval(IInterval $interval): IFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }

    public function withTolerance(ITolerance $tolerance): IFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->tolerance = $tolerance;
        return $clone;
    }
}
