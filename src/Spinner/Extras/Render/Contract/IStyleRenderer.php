<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

interface IStyleRenderer
{
    public function render(IStyle $style): string;
}
