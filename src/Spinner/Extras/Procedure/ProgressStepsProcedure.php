<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressStepsProcedure extends AProgressValueProcedure implements ICharPalette
{
    private const FORMAT = '%3s/%3s';
    private float $stepValue;

    public function __construct(
        IProgressValue $progressValue,
        string $format = self::FORMAT,
    ) {
        parent::__construct(
            progressValue: $progressValue,
            format: $format
        );
        $this->stepValue = ($progressValue->getMax() - $progressValue->getMin()) / $progressValue->getSteps();
    }

    protected function createFrameSequence(): string
    {
        return sprintf(
            $this->format,
            (int)($this->progressValue->getValue() / $this->stepValue),
            $this->progressValue->getSteps()
        );
    }
}
