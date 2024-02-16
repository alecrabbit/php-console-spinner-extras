<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Revolver\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use Generator;
use Traversable;

abstract class AFrameRevolver extends ARevolver implements IFrameRevolver
{
    public function __construct(
        protected IHasFrame $frames,
        IInterval $interval,
    ) {
        parent::__construct($interval);
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->frames->getFrame($dt);
    }
}
