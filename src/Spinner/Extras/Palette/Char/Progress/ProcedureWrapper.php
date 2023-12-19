<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char\Progress;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Extras\Palette\Contract\ITraversableWrapper;
use Traversable;

final readonly class ProcedureWrapper implements ITraversableWrapper
{
    public function __construct(
        private IProcedure $procedure,
    ) {
    }

    public function __invoke(): Traversable
    {
        while (true) {
            yield $this->procedure->getFrame();
        }
    }
}
