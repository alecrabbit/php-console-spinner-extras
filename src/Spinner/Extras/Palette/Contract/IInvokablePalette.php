<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Contract;

use Traversable;

interface IInvokablePalette
{
    public function __invoke(): Traversable;
}
