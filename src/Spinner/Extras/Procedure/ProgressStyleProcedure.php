<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\StyleFrame;
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
        return new StylingFrame(
            sequence: $this->createFrameSequence(),
            width: 0,
            style: new Style(),
        );
    }

    protected function createFrame(string $sequence): IFrame
    {
        return new StyleFrame($sequence, 0);
    }

    protected function createFrameSequence(): string
    {
        $value = $this->progressValue->getValue() * 100;

        return match (true) {
            $value < 0 => "\e[34m%s\e[39m",
            $value < 25 => "\e[31m%s\e[39m",
            $value < 50 => "\e[33m%s\e[39m",
            $value < 75 => "\e[32m%s\e[39m",
            default => '%s',
        };
    }
}
