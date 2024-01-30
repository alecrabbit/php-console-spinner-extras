<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\Contract\IPercentSequenceProcedure;

final class PercentSequenceProcedure extends AFloatValueProcedure implements IPercentSequenceProcedure
{
    private const DEFAULT_SIZE = 10;
    private array $charSequence;

    public function __construct(
        private readonly ILoadSymbolIndex $loadSymbolIndex,
        private readonly int $size = self::DEFAULT_SIZE,
        private IIndexToCodepointConverter $sequenceHelper = new IndexToCodepointConverter(),
        array $charSequence = [],
    ) {
        parent::__construct($this->loadSymbolIndex->getLoadValue());

        $this->loadSymbolIndex->attach($this);
        $this->charSequence = array_pad($charSequence, $this->size, ' ');
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->loadSymbolIndex) {
            $this->addSymbolIndex($subject->get());
        }
    }

    private function addSymbolIndex(int $index): void
    {
        $this->charSequence[] = mb_chr($this->sequenceHelper->getCodepoint($index));

        $this->checkSize();
    }

    private function checkSize(): void
    {
        if (count($this->charSequence) > $this->size) {
            array_shift($this->charSequence);
        }
    }

    protected function createFrameSequence(): string
    {
        return implode('', $this->charSequence);
    }
}
