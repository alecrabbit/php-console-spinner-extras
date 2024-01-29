<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

/**
 * @deprecated
 */
final readonly class LoadToSymbolHelper implements ILoadToSymbolHelper
{
    public function __construct(
        private ILoadValue $loadHelper = new LoadValue(),
        private ISequenceHelper $symbolHelper = new SequenceHelper(),
    ) {
    }

    public function get(float $input): string
    {
        $this->loadHelper->add($input);

        return mb_chr($this->symbolHelper->getCodepoint($this->loadHelper->get()));
    }
}
