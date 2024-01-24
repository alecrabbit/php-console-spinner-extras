<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Extras\Color\Ansi24ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi4ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Ansi8ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorCodesGetterFactory;

final readonly class ColorCodesGetterFactory implements IColorCodesGetterFactory
{
    public function __construct(
        private IOutputConfig $outputConfig,
    ) {
    }

    public function create(): IColorCodesGetter
    {
        $mode = $this->outputConfig->getStylingMethodMode();

        return match ($mode) {
            StylingMethodMode::ANSI4 => new Ansi4ColorCodesGetter(new Ansi4ColorDegrader()),
            StylingMethodMode::ANSI8 => new Ansi8ColorCodesGetter(new Ansi8ColorDegrader()),
            StylingMethodMode::ANSI24 => new Ansi24ColorCodesGetter(),
            default => throw new \LogicException(
                'Unknown mode.' .
                sprintf(
                    ' Got: "%s::%s"',
                    get_debug_type($mode),
                    $mode->name
                )
            ),
        };
    }
}
