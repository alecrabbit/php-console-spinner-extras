<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;

abstract class AProgressValueProcedure extends AFloatValueProcedure
{
    private const FORMAT = "%' 3.0f%%"; // "%' 5.1f%%";

    public function __construct(
        protected readonly IProgressValue $progressValue,
        string $format = self::FORMAT,
        IPaletteOptions $options = new PaletteOptions(),
    ) {
        parent::__construct($progressValue, $format, $options);
    }

    protected function createFrameSequence(): string
    {
        return sprintf(
            $this->format,
            $this->progressValue->getValue() * 100
        );
    }
}
