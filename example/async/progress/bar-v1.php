<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\ProcedureCharPalette;
use AlecRabbit\Spinner\Extras\Procedure\ProgressBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressElapsedProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressEstimateProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressStepsProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressValueProcedure;
use AlecRabbit\Spinner\Extras\ProgressValue;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;

require_once __DIR__ . '/../bootstrap.async.php';

$progressValue =
    new ProgressValue(
        steps: 100,
        threshold: 2, // isFinished(true) will return true on a third call
    );

$progressWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            trailingSpacer: new CharFrame('', 0),
        ),
        new WidgetSettings(
            charPalette: new ProcedureCharPalette(
                procedure: new ProgressElapsedProcedure(
                    progressValue: $progressValue,
                ),
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
            charPalette: new ProcedureCharPalette(
                procedure: new ProgressBarProcedure(
                    progressValue: $progressValue
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
            charPalette: new ProcedureCharPalette(
                procedure: new ProgressEstimateProcedure(
                    progressValue: $progressValue,
                    format: '[%6s]',
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
            // note: isFinished(useThreshold: true) will return true after number of calls set by threshold
            if ($progressValue->isFinished() && $progressValue->isFinished(useThreshold: true)) {
                $spinner->remove($widget->getContext());
            }
        }
    )
;
