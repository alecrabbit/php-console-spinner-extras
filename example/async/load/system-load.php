<?php

declare(strict_types=1);

use AlecRabbit\Color\Gradient\ColorRange;
use AlecRabbit\Color\Gradient\RGBAGradient;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\ProcedureCharPalette;
use AlecRabbit\Spinner\Extras\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\Style\CustomStylePalette;
use AlecRabbit\Spinner\Extras\Palette\Style\ProcedureStylePalette;
use AlecRabbit\Spinner\Extras\Procedure\LoadCharSequenceProcedure;
use AlecRabbit\Spinner\Extras\Procedure\PercentGradientProcedure;
use AlecRabbit\Spinner\Extras\Procedure\PercentValueProcedure;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Value\LoadValue;
use AlecRabbit\Spinner\Helper\LoadSymbolIndex;

require_once __DIR__ . '/../bootstrap.async.php';

$updateInterval = 500; // milliseconds

$loadValue = new LoadValue();
$loadSymbolIndex = new LoadSymbolIndex(loadValue: $loadValue);
$size = 10;

$options = new PaletteOptions(interval: $updateInterval);

$gradient = new RGBAGradient(
    range: new ColorRange(
        start: '#fff',
        end: '#f00',
    ),
);
$gradientTwo = new RGBAGradient(
    range: new ColorRange(
        start: '#666',
        end: '#666',
    ),
);
$loadWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            stylePalette: new ProcedureStylePalette(
                procedure: new PercentGradientProcedure(
                    floatValue: $loadValue,
                    gradient: $gradientTwo,
                ),
            ),
            charPalette: new ProcedureCharPalette(
                procedure: new LoadCharSequenceProcedure(
                    loadSymbolIndex: $loadSymbolIndex,
                    size: $size,
                ),
                options: $options,
            ),
        ),
        new WidgetSettings(
            stylePalette: new ProcedureStylePalette(
                procedure: new PercentGradientProcedure(
                    floatValue: $loadValue,
                    gradient: $gradient,
                ),
                options: $options,
            ),
            charPalette: new ProcedureCharPalette(
                procedure: new PercentValueProcedure(
                    floatValue: $loadValue,
                ),
                options: $options,
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

// simulate load
$loop
    ->repeat(
        $updateInterval / 2000, // seconds
        static function () use ($loadValue): void {
            static $last = 0.0;

            $current = random_int(0, 100) / 100;

//            // FIXME (2024-01-29 17:36) [Alec Rabbit]: stub for 8 cpu system
//            $current = sys_getloadavg()[0] / 8;

            $load = $last * 0.6 + $current * 0.4;

            $loadValue->setLoad($load);
            $last = $load;
        }
    )
;
