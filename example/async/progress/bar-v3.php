<?php

declare(strict_types=1);

use AlecRabbit\Color\Gradient\ColorRange;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\Moon;
use AlecRabbit\Spinner\Extras\Palette\Char\ProcedureCharPalette;
use AlecRabbit\Spinner\Extras\Palette\Style\ProcedureStylePalette;
use AlecRabbit\Spinner\Extras\Procedure\PercentGradientProcedure;
use AlecRabbit\Spinner\Extras\Procedure\PercentValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressElapsedProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressEstimateProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressStepsProcedure;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Value\ProgressValue;

require_once __DIR__ . '/../bootstrap.async.php';

Facade::getSettings()
    ->set(
        new OutputSettings(
            stylingMethodOption: StylingMethodOption::ANSI24,
        )
    )
;

$units = 10;
$steps = 100;

// Note: We'll use the same progress value for both widgets
$progressValue =
    new ProgressValue(
        steps: $steps,
    );

$gradientOne = new AlecRabbit\Color\Gradient\HSLAGradient(
    range: new ColorRange(
        start: 'hsl(0, 100%, 20%)',
        end: 'hsl(120, 0%, 100%)',
    ),
);

$gradientTwo = new AlecRabbit\Color\Gradient\RGBAGradient(
    range: new ColorRange(
        start: new DRGB(1, 0, 0),
        end: 'hsl(120, 0%, 100%)',
    ),
);

$progressWidgetOneSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            charPalette: new Moon(options: new PaletteOptions(interval: 100)),
        ),
        new WidgetSettings(
            charPalette: new ProgressStepsProcedure(
                progressValue: $progressValue,
                format: '%2s/%2s',
            ),
        ),
        new WidgetSettings(
            stylePalette: new PercentGradientProcedure(
                floatValue: $progressValue,
                gradient: $gradientOne,

            ),
            charPalette: new ProgressBarProcedure(
                progressValue: $progressValue,
                units: $units,
            ),
        ),
        new WidgetSettings(
            charPalette: new PercentValueProcedure(
                floatValue: $progressValue
            ),
        ),
    );

$progressWidgetTwoSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            charPalette: new ProgressElapsedProcedure(
                progressValue: $progressValue,
                format: '🕐 [%6s]',
            ),
        ),
        new WidgetSettings(
            stylePalette: new PercentGradientProcedure(
                    floatValue: $progressValue,
                    gradient: $gradientTwo,
            ),
            charPalette: new ProgressEstimateProcedure(
                    progressValue: $progressValue,
                    format: '🏁 [%6s]',
                ),
        ),
    );

/** @var IWidgetComposite $widgetOne */
$widgetOne =
    Facade::getWidgetFactory()
        ->usingSettings($progressWidgetOneSettings)
        ->create()
;

/** @var IWidgetComposite $widgetTwo */
$widgetTwo =
    Facade::getWidgetFactory()
        ->usingSettings($progressWidgetTwoSettings)
        ->create()
;

$spinner = Facade::createSpinner();

$spinner->add($widgetOne->getContext());
$spinner->add($widgetTwo->getContext());

$loop = Facade::getLoop();

// simulate progress
$loop
    ->repeat(
        0.01,
        static function () use ($progressValue): void {
            if (random_int(0, 100) < 5) {
                $progressValue->advance();
            }
        }
    )
;

// remove widget when progress is finished
$loop
    ->repeat(
        1,
        static function () use ($progressValue, $spinner, $widgetOne, $widgetTwo, $loop): void {
            if ($progressValue->isFinished()) {
                $loop->delay(
                    5,
                    static function () use ($spinner, $widgetOne): void {
                        $spinner->remove($widgetOne->getContext());
                    }
                );

                $loop->delay(
                    15,
                    static function () use ($spinner, $widgetTwo): void {
                        $spinner->remove($widgetTwo->getContext());
                    }
                );
            }
        }
    )
;
