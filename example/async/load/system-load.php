<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\ProcedureCharPalette;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;

require_once __DIR__ . '/../bootstrap.async.php';


$loadValue = 1;

$loadWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            charPalette: new ProcedureCharPalette(
                procedure: new LoadCharSequenceProcedure(
                    loadValue: $loadValue,
                ),
            ),
        ),

    );

/** @var IWidgetComposite $widget */
$widget =
    Facade::getWidgetFactory()
        ->usingSettings($loadWidgetSettings)
        ->create()
;

$spinner = Facade::createSpinner();

$spinner->add($widget->getContext());

//$loop = Facade::getLoop();
//
//// simulate progress
//$loop
//    ->repeat(
//        0.1,
//        static function () use ($progressValue): void {
//            $progressValue->advance();
//        }
//    )
//;
//
//// remove widget when progress is finished
//$loop
//    ->repeat(
//        1,
//        static function () use ($progressValue, $spinner, $widget, $loop): void {
//            if ($progressValue->isFinished()) {
//                $loop->delay(
//                    5,
//                    static function () use ($spinner, $widget): void {
//                        $spinner->remove($widget->getContext());
//                    }
//                );
//            }
//        }
//    )
//;
