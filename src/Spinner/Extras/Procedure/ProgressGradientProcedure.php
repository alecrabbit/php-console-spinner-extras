<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Contract\IStylingFrame;
use AlecRabbit\Spinner\Extras\Frame\StylingFrame;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use RuntimeException;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressGradientProcedure extends AProgressValueProcedure
{
    private int $count;

    public function __construct(
        IProgressValue $progressValue,
        private readonly IGradient $gradient,
    ) {
        parent::__construct($progressValue);
        $this->count = $gradient->getCount();
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return new StylingFrame(
            style: new Style(
                fgColor: $this->getFgColor(),
            ),
        );
    }

    private function getFgColor(): IColor
    {
        return $this->gradient->getOne($this->getIndex());
    }

    protected function createFrame(string $sequence): IFrame
    {
        return new StyleFrame($sequence, 0);
    }

    protected function createFrameSequence(): string
    {
        // TODO (2024-01-23 17:04) [Alec Rabbit]: refactor to remove this method
        throw new RuntimeException('Not implemented');
    }

    protected function getIndex(): mixed
    {
        return min(
            $this->count,
            max(0, (int)($this->progressValue->getValue() * $this->count) - 1)
        );
    }
}
