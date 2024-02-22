<?php

declare(strict_types=1);

use AlecRabbit\Color\Gradient\ColorRange;
use AlecRabbit\Color\Gradient\RGBAGradient;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\ClockDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\ProcedureCharPalette;
use AlecRabbit\Spinner\Extras\Palette\Style\ProcedureStylePalette;
use AlecRabbit\Spinner\Extras\Procedure\PercentageSymbolIndex;
use AlecRabbit\Spinner\Extras\Procedure\PercentGradientProcedure;
use AlecRabbit\Spinner\Extras\Procedure\PercentSequenceProcedure;
use AlecRabbit\Spinner\Extras\Procedure\PercentValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\TimerProcedure;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Value\PercentValue;

require_once __DIR__ . '/../bootstrap.async.php';

$updateInterval = 500; // milliseconds

$loadValue = new PercentValue();
$loadSymbolIndex = new PercentageSymbolIndex(loadValue: $loadValue);
$size = 4;

$options = new PaletteOptions(interval: $updateInterval);

$gradient = new RGBAGradient(
    range: new ColorRange(
        start: '#fff',
        end: '#f00',
    ),
);
$gradientTwo = new RGBAGradient(
    range: new ColorRange(
        start: '#aaa',
        end: '#bbb',
    ),
);
$loadWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            stylePalette: new PercentGradientProcedure(
                floatValue: $loadValue,
                gradient: $gradient,
                options: $options,
            ),
            charPalette: new PercentValueProcedure(
                floatValue: $loadValue,
                options: $options,
            ),
        ),
        new WidgetSettings(
            stylePalette: new PercentGradientProcedure(
                floatValue: $loadValue,
                gradient: $gradientTwo,
            ),
            charPalette: new PercentSequenceProcedure(
                percentageSymbolIndex: $loadSymbolIndex,
                size: $size,
                options: $options,
            ),
        ),
        new WidgetSettings(
            charPalette: new TimerProcedure(
                target: new DateTimeImmutable('+86410 seconds'),
                intervalFormatter: new ClockDateIntervalFormatter(),
                format: '[%s]',
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

            $load = $last * 0.65 + $current * 0.35;

            $loadValue->setPercent($load);
            $last = $load;
        }
    )
;
