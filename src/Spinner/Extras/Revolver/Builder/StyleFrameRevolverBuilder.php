<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Revolver\Builder\Contract\IStyleFrameRevolverBuilder;
use AlecRabbit\Spinner\Extras\Revolver\StyleFrameRevolver;
use Traversable;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class StyleFrameRevolverBuilder implements IStyleFrameRevolverBuilder
{
    /** @var Traversable<IFrame>|null */
    private ?Traversable $frames = null;
    private ?IInterval $interval = null;
    private ?ITolerance $tolerance = null;
    private ?IStyleRenderer $styleRenderer = null;

    public function build(): IFrameRevolver
    {
        $this->validate();

        return new StyleFrameRevolver(
            $this->frames,
            $this->interval,
            $this->tolerance,
            $this->styleRenderer,
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
            $this->styleRenderer === null => throw new LogicException('Style renderer is not set.'),
            default => null,
        };
    }

    /** @inheritDoc */
    public function withFrames(Traversable $frames): IStyleFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->frames = $frames;
        return $clone;
    }

    public function withInterval(IInterval $interval): IStyleFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->interval = $interval;
        return $clone;
    }

    public function withTolerance(ITolerance $tolerance): IStyleFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->tolerance = $tolerance;
        return $clone;
    }

    public function withStyleRenderer(IStyleRenderer $styleRenderer): IStyleFrameRevolverBuilder
    {
        $clone = clone $this;
        $clone->styleRenderer = $styleRenderer;
        return $clone;
    }
}
