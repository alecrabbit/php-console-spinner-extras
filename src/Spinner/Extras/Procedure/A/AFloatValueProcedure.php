<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Extras\Contract\IFloatValue;

use function AlecRabbit\WCWidth\wcswidth;

abstract class AFloatValueProcedure extends AProcedure
{
    private const FORMAT = '%s';

    public function __construct(
        protected readonly IFloatValue $floatValue,
        protected readonly string $format = self::FORMAT,
    ) {
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createSequenceFrame(
            $this->createFrameSequence()
        );
    }

    protected function createSequenceFrame(string $sequence): ISequenceFrame
    {
        if ($sequence === '') {
            return new CharFrame('', 0);
        }
        return new CharFrame($sequence, $this->getWidth($sequence));
    }

    protected function getWidth(string $value): int
    {
        return wcswidth($value);
    }

    protected function createFrameSequence(): string
    {
        return sprintf(
            $this->format,
            $this->floatValue->getValue()
        );
    }
}
