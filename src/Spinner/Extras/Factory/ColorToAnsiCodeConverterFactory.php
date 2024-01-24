<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Extras\Color\Ansi4BrightnessChecker;
use AlecRabbit\Spinner\Extras\Color\Ansi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Ansi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\ColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Color\HexColorNormalizer;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorToAnsiCodeConverterFactory;

final readonly class ColorToAnsiCodeConverterFactory implements IColorToAnsiCodeConverterFactory
{
    public function __construct(
        private IOutputConfig $outputConfig,
    ) {
    }


    public function create(): IColorToAnsiCodeConverter
    {
        // TODO (2024-01-23 15:31) [Alec Rabbit]: refactor -> implement `IColorToAnsiCodeConverterBuilder`?
        return new ColorToAnsiCodeConverter(
            mode: $this->outputConfig->getStylingMethodMode(),
            hexColorNormalizer: new HexColorNormalizer(),
            ans4BrightnessChecker: new Ansi4BrightnessChecker(),
            ansi4ColorDegrader: new Ansi4ColorDegrader(),
            ansi8ColorDegrader: new Ansi8ColorDegrader(),
        );
    }
}
