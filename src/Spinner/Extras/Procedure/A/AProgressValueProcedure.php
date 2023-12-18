<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Extras\Contract\IProgressValue;

abstract class AProgressValueProcedure extends AFloatValueProcedure
{
    private const FORMAT = "%' 3.0f%%"; // "%' 5.1f%%";

    public function __construct(
        protected readonly IProgressValue $progressValue,
        string $format = self::FORMAT,
    ) {
        parent::__construct($progressValue, $format);
    }

    protected function createFrameSequence(): string
    {
        return sprintf(
            $this->format,
            $this->progressValue->getValue() * 100
        );
    }
}
