<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\Progress\InvokablePalette;
use AlecRabbit\Spinner\Extras\Palette\Char\ProgressCharPalette;
use AlecRabbit\Spinner\Extras\Procedure\ProgressBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressStepsProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressValueProcedure;
use AlecRabbit\Spinner\Extras\ProgressValue;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;

require_once __DIR__ . '/../bootstrap.async.php';

$progressValue =
    new ProgressValue(
        steps: 10,
        threshold: 2, // isFinished(true) will return true on a third call
    );

// without interval set, default value will be used - 15min
$progressOptions =
    new PaletteOptions(
        interval: 200,
    );

$progressWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            trailingSpacer: new CharFrame('', 0),
        ),
        new WidgetSettings(
            charPalette: new ProgressCharPalette(
                palette: new InvokablePalette(
                    procedure: new ProgressStepsProcedure(
                        progressValue: $progressValue,
                        format: '%2s/%2s',
                    ),
                ),
                options: $progressOptions,
            ),
        ),
        new WidgetSettings(
            charPalette: new ProgressCharPalette(
                palette: new InvokablePalette(
                    procedure: new ProgressBarProcedure(
                        progressValue: $progressValue
                    ),
                ),
                options: $progressOptions,
            ),
        ),
        new WidgetSettings(
            charPalette: new ProgressCharPalette(
                palette: new InvokablePalette(
                    procedure: new ProgressValueProcedure(
                        progressValue: $progressValue
                    ),
                ),
                options: $progressOptions,
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
        0.1,
        static function () use ($progressValue): void {
            $progressValue->advance();
        }
    )
;

// remove widget when progress is finished
$loop
    ->repeat(
        1,
        static function () use ($progressValue, $spinner, $widget): void {
            if ($progressValue->isFinished() && $progressValue->isFinished(useThreshold: true)) {
                $spinner->remove($widget->getContext());
            }
        }
    )
;
