<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\Moon;
use AlecRabbit\Spinner\Extras\Palette\Char\ProcedureCharPalette;
use AlecRabbit\Spinner\Extras\Palette\Style\ProcedureStylePalette;
use AlecRabbit\Spinner\Extras\Procedure\ProgressBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressElapsedProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressEstimateProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressStepsProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressStyleProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressValueProcedure;
use AlecRabbit\Spinner\Extras\ProgressBarSprite;
use AlecRabbit\Spinner\Extras\ProgressValue;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;

require_once __DIR__ . '/../bootstrap.async.php';

$progressValue =
    new ProgressValue(
        steps: 10,
    );

$progressWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            trailingSpacer: new CharFrame('', 0),
        ),
        // nested multi settings
        new MultiWidgetSettings(
            new WidgetSettings(
                charPalette: new ProcedureCharPalette(
                    procedure: new ProgressElapsedProcedure(
                        progressValue: $progressValue,
                        format: '🕐 [%6s]',
                    ),
                ),
            ),
            new WidgetSettings(
                charPalette: new Moon(options: new PaletteOptions(interval: 100)),
            ),
        ),
        new WidgetSettings(
            charPalette: new ProcedureCharPalette(
                procedure: new ProgressStepsProcedure(
                    progressValue: $progressValue,
                    format: '%2s/%2s',
                ),
            ),
        ),
        new WidgetSettings(
            stylePalette: new ProcedureStylePalette(
                procedure: new ProgressStyleProcedure(
                    progressValue: $progressValue,
                ),
            ),
            charPalette: new ProcedureCharPalette(
                procedure: new ProgressBarProcedure(
                    progressValue: $progressValue,
                    sprite: new ProgressBarSprite(
                        sample: '■▨□',
//                            sample: '⬛⬛⬜',
//                            sample: '⬤⬤◯',
//                            sample: '▰▱▱',
                    ),
                    units: 20,
                ),
            ),
        ),
        new WidgetSettings(
            charPalette: new ProcedureCharPalette(
                procedure: new ProgressValueProcedure(
                    progressValue: $progressValue
                ),
            ),
        ),
        new WidgetSettings(
            stylePalette: new ProcedureStylePalette(
                procedure: new ProgressStyleProcedure(
                    progressValue: $progressValue,
                ),
            ),
            charPalette: new ProcedureCharPalette(
                procedure: new ProgressEstimateProcedure(
                    progressValue: $progressValue,
                    format: '🏁 [%6s]',
                ),
            ),
        ),
    );

/** @var IWidgetComposite $widget */
$widget =
    Facade::getWidgetFactory()
        ->usingSettings($progressWidgetSettings)
        ->create()
;

$spinner = Facade::createSpinner();

$spinner->add($widget->getContext());

$loop = Facade::getLoop();

// simulate progress
$loop
    ->repeat(
        0.01,
        static function () use ($progressValue): void {
            if (\random_int(0, 100) < 5) {
                $progressValue->advance();
            }
        }
    )
;

// remove widget when progress is finished
$loop
    ->repeat(
        1,
        static function () use ($progressValue, $spinner, $widget, $loop): void {
            if ($progressValue->isFinished()) {
                $loop->delay(
                    5,
                    static function () use ($spinner, $widget): void {
                        $spinner->remove($widget->getContext());
                    }
                );
            }
        }
    )
;
