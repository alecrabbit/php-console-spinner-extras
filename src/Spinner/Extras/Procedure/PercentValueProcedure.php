<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Extras\Contract\IFloatValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;

/**
 * @psalm-suppress UnusedClass
 */
final class PercentValueProcedure extends AFloatValueProcedure
{
    private const FORMAT = "%' 3.0f%%"; // "%' 5.1f%%";

    public function __construct(
        IFloatValue $floatValue,
        string $format = self::FORMAT,
    ) {
        parent::__construct($floatValue, $format);
    }

    protected function createFrameSequence(): string
    {
        return sprintf(
            $this->format,
            $this->floatValue->getValue() * 100
        );
    }
}
