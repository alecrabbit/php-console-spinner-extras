<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use Generator;
use Traversable;

final class FrameRevolver extends ARevolver implements IFrameRevolver
{
    /** @var Generator<IFrame> */
    private Generator $frames;

    /**
     * @param Traversable<IFrame> $frames
     * @throws InvalidArgument
     */
    public function __construct(
        Traversable $frames,
        IInterval $interval,
        ITolerance $tolerance,
    ) {
        parent::__construct($interval, $tolerance);

        self::assertFrames($frames);

        /** @var Generator<IFrame> $frames */
        $this->frames = $frames;
    }

    protected function next(?float $dt = null): void
    {
        $this->frames->next();
    }

    protected function current(): IFrame
    {
        return $this->frames->current();
    }

    protected static function assertFrames(Traversable $frames): void
    {
        match (true) {
            $frames instanceof Generator => null,
            default => throw new InvalidArgument(
                sprintf(
                    'Frames must be an instance of infinite %s. "%s" given.',
                    Generator::class,
                    get_debug_type($frames)
                )
            ),
        };
    }
}
