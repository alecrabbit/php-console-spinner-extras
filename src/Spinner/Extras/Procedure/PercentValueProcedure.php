<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

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

    protected function createFrameSequence(): string
    {
        return sprintf(
            $this->format,
            $this->floatValue->getValue() * 100
        );
    }
}
