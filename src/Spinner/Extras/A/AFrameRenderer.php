<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\A;

use AlecRabbit\Spinner\Extras\Contract\IFrameRenderer;
use AlecRabbit\Spinner\Extras\Factory\Contract\ICharFrameFactory;

abstract class AFrameRenderer implements IFrameRenderer
{
    public function __construct(
        protected ICharFrameFactory $frameFactory,
    ) {
    }
}
