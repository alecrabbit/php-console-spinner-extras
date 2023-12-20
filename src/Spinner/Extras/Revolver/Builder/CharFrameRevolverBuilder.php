<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Revolver\Builder\Contract\ICharFrameRevolverBuilder;
use AlecRabbit\Spinner\Extras\Revolver\CharFrameRevolver;
use Traversable;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class CharFrameRevolverBuilder implements ICharFrameRevolverBuilder
{
    /** @var Traversable<IFrame>|null */
    private ?Traversable $frames = null;
    private ?IInterval $interval = null;
    private ?ITolerance $tolerance = null;

    public function build(): IFrameRevolver
    {
        $this->validate();

        return new CharFrameRevolver(
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
    public function withFrames(Traversable $frames): ICharFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->frames = $frames;
        return $clone;
    }

    public function withInterval(IInterval $interval): ICharFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }

    public function withTolerance(ITolerance $tolerance): ICharFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->tolerance = $tolerance;
        return $clone;
    }
}
