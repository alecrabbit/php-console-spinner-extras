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
final class ProgressStyleProcedure extends AProgressValueProcedure
{
    public function __construct(
        IProgressValue $progressValue,
        private readonly IGradient $gradient,
    ) {
        parent::__construct($progressValue);
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createStyleFrame();
    }

    private function createStyleFrame(): IStylingFrame
    {
        return new StylingFrame(
            style: new Style(
                fgColor: $this->getFgColor(),
            ),
        );
    }

    private function getFgColor(): IColor
    {
        $count = $this->gradient->getCount();
        $index =
            min(
                $count,
                max((int)($this->progressValue->getValue() * $count) - 1, 0)
            );

        return $this->gradient->getOne($index);
    }

    protected function createFrame(string $sequence): IFrame
    {
        return new StyleFrame($sequence, 0);
    }

    protected function createFrameSequence(): string
    {
        throw new RuntimeException('Not implemented');
    }
}
