<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Contract\IFrame;


interface ICharFrameRenderer extends IFrameRenderer
{
    public function render(string $entry): IFrame;
}
