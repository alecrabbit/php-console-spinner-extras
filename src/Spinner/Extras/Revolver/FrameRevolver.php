<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgument;

final class FrameRevolver extends ARevolver implements IFrameRevolver
{
    private \Generator $frames;

    public function __construct(
        \Traversable $frames,
        IInterval $interval,
        ITolerance $tolerance,
    ) {
        parent::__construct($interval, $tolerance);

        if (!$frames instanceof \Generator) {
            throw new InvalidArgument(
                sprintf(
                    'Frames must be an instance of %s. "%s" given.',
                    \Generator::class,
                    get_debug_type($frames)
                )
            ); // TODO (2023-12-08 17:13) [Alec Rabbit]: clarify message about infinite generator
        }

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
}
