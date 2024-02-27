<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IProgressWrapper;

abstract class AProgressValueProcedure extends AFloatValueProcedure
{
    private const FORMAT = "%' 3.0f%%"; // "%' 5.1f%%";

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
            $this->wrapper->unwrap() * 100
        );
    }

    protected function assertReference(): void
    {
        if (!$this->reference->getWrapper() instanceof IProgressWrapper) {
            throw new InvalidArgument(
                sprintf(
                    'Reference value is expected to contain an instance of %s.',
                    IProgressWrapper::class
                )
            );
        }
    }
}
