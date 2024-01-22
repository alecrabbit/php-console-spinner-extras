<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4BrightnessChecker;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Contract\IAnsiCode;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;

final readonly class ColorToAnsiCodeConverter implements IColorToAnsiCodeConverter
{
    public function __construct(
        private StylingMethodMode $mode,
        private IHexColorNormalizer $hexColorNormalizer,
        private IAnsi4BrightnessChecker $ans4BrightnessChecker,
        private IAnsi4ColorDegrader $ansi4ColorDegrader,
        private IAnsi8ColorDegrader $ansi8ColorDegrader,
    ) {
    }

    public function convert(IColor|string $color): IAnsiCode
    {
        $color = $this->hexColorNormalizer->normalize($color);

        return $this->doConvert($color);
    }

    private function doConvert(IHexColor $color): IAnsiCode
    {
        $codes = $this->getCodes($color->getRed(), $color->getGreen(), $color->getBlue());

        return $this->isBright($color)
            ? new BrightAnsiCode(...$codes)
            : new AnsiCode(...$codes);
    }

    protected function getCodes(int $r, int $g, int $b): iterable
    {
        return match ($this->mode) {
            StylingMethodMode::ANSI4 => [$this->ansi4ColorDegrader->degrade($r, $g, $b)],
            StylingMethodMode::ANSI8 => [8, 5, $this->ansi8ColorDegrader->degrade($r, $g, $b)],
            StylingMethodMode::ANSI24 => [8, 2, $r, $g, $b,],
            default => throw new LogicException('Unsupported mode.'),
        };
    }

    protected function isBright(IHexColor $color): bool
    {
        return match ($this->mode) {
            StylingMethodMode::ANSI4 => $this->ans4BrightnessChecker->isBright($color),
            default => false,
        };
    }
}
