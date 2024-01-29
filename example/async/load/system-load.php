<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\ProcedureCharPalette;
use AlecRabbit\Spinner\Extras\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Procedure\LoadCharSequenceProcedure;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Value\LoadValue;
use AlecRabbit\Spinner\Helper\LoadSymbolIndex;

require_once __DIR__ . '/../bootstrap.async.php';

$loadValue = new LoadValue();

$loadSymbolIndex = new LoadSymbolIndex(loadValue: $loadValue);

$loadWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            charPalette: new ProcedureCharPalette(
                procedure: new LoadCharSequenceProcedure(
                    loadValue: $loadValue,
                    loadSymbolIndex: $loadSymbolIndex,
                ),
                options: new PaletteOptions(
                    interval: 10000,
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

$loop = Facade::getLoop();

// simulate progress
$loop
    ->repeat(
        5,
        static function () use ($loadValue): void {
            $load = random_int(0, 100) / 100;

//            // FIXME (2024-01-29 17:36) [Alec Rabbit]: stub for 8 cpu system
//            $load = sys_getloadavg()[0] / 8;

            $loadValue->setLoad($load);
        }
    )
;
