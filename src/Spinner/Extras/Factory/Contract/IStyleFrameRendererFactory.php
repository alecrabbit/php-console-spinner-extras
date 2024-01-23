<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;

/**
 * @deprecated
 */
interface IStyleFrameRendererFactory
{
    public function create(StylingMethodOption $mode): IStyleFrameRenderer;
}
