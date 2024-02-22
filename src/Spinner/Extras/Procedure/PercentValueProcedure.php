<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\IFloatValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;

/**
 * @psalm-suppress UnusedClass
 */
final class PercentValueProcedure extends AFloatValueProcedure implements ICharPalette
{
    private const FORMAT = "%' 3.0f%%"; // "%' 5.1f%%";

    public function __construct(
        IFloatValue $floatValue,
        string $format = self::FORMAT,
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct($floatValue, $format, $options);
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
            $this->floatValue->getValue() * 100
        );
    }
}
