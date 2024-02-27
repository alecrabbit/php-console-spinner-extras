<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressStepsProcedure extends AProgressValueProcedure implements ICharPalette
{
    private const FORMAT = '%3s/%3s';
    private float $stepValue;

    public function __construct(
        IValueReference $reference,
        string $format = self::FORMAT,
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct($reference, $format, $options);

        $this->stepValue = ($this->wrapper->getMax() - $this->wrapper->getMin())
            / $this->wrapper->getSteps();
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

    private function createFrameSequence(): string
    {
        return sprintf(
            $this->format,
            (int)($this->wrapper->unwrap() / $this->stepValue),
            $this->wrapper->getSteps()
        );
    }
}
