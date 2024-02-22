<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\Contract\IIndexToCodepointConverter;
use AlecRabbit\Spinner\Extras\Procedure\Contract\IPercentageSymbolIndex;
use AlecRabbit\Spinner\Extras\Procedure\Contract\IPercentSequenceProcedure;

final class PercentSequenceProcedure extends AFloatValueProcedure implements IPercentSequenceProcedure, ICharPalette
{
    private const DEFAULT_SIZE = 10;
    private array $charSequence;

    public function __construct(
        private readonly IPercentageSymbolIndex $percentageSymbolIndex,
        private readonly int $size = self::DEFAULT_SIZE,
        private readonly IIndexToCodepointConverter $codepointConverter = new IndexToCodepointConverter(),
        array $charSequence = [],
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct($this->percentageSymbolIndex->getValue(), options: $options);

        $this->percentageSymbolIndex->attach($this);
        $this->charSequence = array_pad($charSequence, $this->size, ' ');
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->percentageSymbolIndex) {
            $this->addSymbolIndex($subject->get());
        }
    }
    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createSequenceFrame(
            $this->createFrameSequence()
        );
    }

    private function createSequenceFrame(string $sequence): ISequenceFrame
    {
        if ($sequence === '') {
            return new CharSequenceFrame('', 0);
        }
        return new CharSequenceFrame($sequence, $this->getWidth($sequence));
    }

    private function addSymbolIndex(int $index): void
    {
        $this->charSequence[] = mb_chr($this->codepointConverter->getCodepoint($index));

        $this->checkSize();
    }

    private function checkSize(): void
    {
        if (count($this->charSequence) > $this->size) {
            array_shift($this->charSequence);
        }
    }

    private function createFrameSequence(): string
    {
        return implode('', $this->charSequence);
    }
}
