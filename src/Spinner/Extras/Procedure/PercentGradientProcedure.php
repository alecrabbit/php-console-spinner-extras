<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Contract\IFloatValue;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Frame\StyleFrame;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use RuntimeException;

/**
 * @psalm-suppress UnusedClass
 */
final class PercentGradientProcedure extends AFloatValueProcedure
{
    private int $count;

    public function __construct(
        IFloatValue $floatValue,
        private readonly IGradient $gradient,
    ) {
        parent::__construct($floatValue);
        $this->count = $floatValue instanceof IProgressValue
            ? $floatValue->getSteps()
            : 100;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return new StyleFrame(
            style: new Style(
                fgColor: $this->getFgColor(),
            ),
        );
    }

    private function getFgColor(): IColor
    {
        return $this->gradient->getOne($this->getIndex(), $this->count);
    }

    protected function getIndex(): mixed
    {
        return min(
            $this->count,
            max(0, (int)($this->floatValue->getValue() * $this->count) - 1)
        );
    }

    protected function createSequenceFrame(string $sequence): ISequenceFrame
    {
        // TODO (2024-01-23 17:04) [Alec Rabbit]: refactor to remove this method
        throw new RuntimeException('Not implemented');
    }

    protected function createFrameSequence(): string
    {
        // TODO (2024-01-23 17:04) [Alec Rabbit]: refactor to remove this method
        throw new RuntimeException('Not implemented');
    }
}
