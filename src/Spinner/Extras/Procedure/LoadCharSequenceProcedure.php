<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;
use AlecRabbit\Spinner\Extras\Value\ILoadValue;
use AlecRabbit\Spinner\Helper\ILoadSymbolIndex;
use AlecRabbit\Spinner\Helper\ISequenceHelper;
use AlecRabbit\Spinner\Helper\SequenceHelper;

final class LoadCharSequenceProcedure extends AFloatValueProcedure implements ILoadCharSequenceProcedure
{
    private const DEFAULT_SIZE = 10;
    private array $charSequence;

    public function __construct(
        ILoadValue $loadValue,
        private readonly ILoadSymbolIndex $loadSymbolIndex,
        private readonly int $size = self::DEFAULT_SIZE,
        private ISequenceHelper $sequenceHelper = new SequenceHelper(),
        array $charSequence = [],
    ) {
        parent::__construct($loadValue);

        $loadValue->attach($this->loadSymbolIndex);
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
