<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver\Builder\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use Traversable;

interface IStyleFrameRevolverBuilder extends IFrameRevolverBuilder
{
    public function withFrames(Traversable $frames): IStyleFrameRevolverBuilder;

    public function withInterval(IInterval $interval): IStyleFrameRevolverBuilder;

    public function withTolerance(ITolerance $tolerance): IStyleFrameRevolverBuilder;
}
