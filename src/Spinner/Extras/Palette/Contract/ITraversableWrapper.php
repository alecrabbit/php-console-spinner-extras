<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Contract;

use Traversable;

interface ITraversableWrapper
{
    public function __invoke(): Traversable;
}
