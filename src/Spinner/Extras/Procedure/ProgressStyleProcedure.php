<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Color\Contract\IColor;
use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Contract\IStylingFrame;
use AlecRabbit\Spinner\Extras\Frame\StylingFrame;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressStyleProcedure extends AProgressValueProcedure
{
    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createStylingFrame();
    }

    private function createStylingFrame(): IStylingFrame
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
        $value = $this->progressValue->getValue() * 100;

        return match (true) {
            $value < 0 => '#000000',
            $value < 25 => '#aa0011',
            $value < 50 => '#dddd00',
            $value < 75 => '#00ffdd',
            default => null,
        };
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
