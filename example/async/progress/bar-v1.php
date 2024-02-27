<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\ProcedureCharPalette;
use AlecRabbit\Spinner\Extras\Procedure\PercentValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressElapsedProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressEstimateProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressStepsProcedure;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Value\ProgressWrapper;
use AlecRabbit\Spinner\Extras\Value\ValueReference;

require_once __DIR__ . '/../bootstrap.async.php';

$progressValue =
    new ProgressWrapper(
        steps: 100,
    );

$progressReference = new ValueReference($progressValue);

$progressWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            trailingSpacer: new CharSequenceFrame('', 0),
        ),
        new WidgetSettings(
            charPalette: new ProgressElapsedProcedure(
                reference: $progressReference,
            ),
        ),
        new WidgetSettings(
            charPalette: new ProgressStepsProcedure(
                reference: $progressReference,
                format: '%2s/%2s',
            ),
        ),
        new WidgetSettings(
            charPalette: new ProgressBarProcedure(
                reference: $progressReference,
            ),
        ),
        new WidgetSettings(
            charPalette: new PercentValueProcedure(
                reference: $progressReference,
            ),
        ),
        new WidgetSettings(
            charPalette: new ProgressEstimateProcedure(
                reference: $progressReference,
                format: '[%6s]',
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
