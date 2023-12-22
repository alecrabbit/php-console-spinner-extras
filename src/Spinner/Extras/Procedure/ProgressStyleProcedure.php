<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Contract\IStylingFrame;
use AlecRabbit\Spinner\Extras\Frame\StylingFrame;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressStyleProcedure extends AProgressValueProcedure
{
    public function __construct(
        IProgressValue $progressValue,
        private IGradient $gradient,
    ) {
        parent::__construct($progressValue);
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createStyleFrame();
    }

    private function createStyleFrame(): IStylingFrame
    {
        $fgColor = $this->getFgColor();

        $style = $fgColor === null
            ? new Style()
            : new Style(
                fgColor: $fgColor
            );

        return new StylingFrame(
            style: $style,
        );
    }

    private function getFgColor(): IColor|string|null
    {
        $count = $this->gradient->getCount();
        $index =
            min(
                $count,
                max((int)($this->progressValue->getValue() * $count) - 1, 0)
            );

        return $this->gradient->getOne($index)->to(IHexColor::class)->toString();
    }

    protected function createFrame(string $sequence): IFrame
    {
        return new StyleFrame($sequence, 0);
    }

    protected function createFrameSequence(): string
    {
        throw new \RuntimeException('Not implemented');
    }
}
