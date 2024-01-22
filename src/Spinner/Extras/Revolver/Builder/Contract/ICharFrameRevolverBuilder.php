<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver\Builder\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use Traversable;

interface ICharFrameRevolverBuilder extends IFrameRevolverBuilder
{
    public function withFrames(Traversable $frames): ICharFrameRevolverBuilder;

    public function withInterval(IInterval $interval): ICharFrameRevolverBuilder;

    public function withTolerance(ITolerance $tolerance): ICharFrameRevolverBuilder;

}
