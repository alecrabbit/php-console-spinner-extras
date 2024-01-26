<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

final readonly class LoadToSymbolHelper implements ILoadToSymbolHelper
{
    public function __construct(
        private ILoadHelper $loadHelper = new LoadHelper(),
        private ISequenceHelper $symbolHelper = new SequenceHelper(),
    ) {
    }

    public function get(float $input): string
    {
        $this->loadHelper->add($input);

        return $this->symbolHelper->get($this->loadHelper->get());
    }
}
