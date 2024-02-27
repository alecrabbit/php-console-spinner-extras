<?php

declare(strict_types=1);

use AlecRabbit\Color\Gradient\ColorRange;
use AlecRabbit\Color\Gradient\RGBAGradient;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\ClockDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\EstimateDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\FineDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Palette\Char\ProcedureCharPalette;
use AlecRabbit\Spinner\Extras\Palette\Style\ProcedureStylePalette;
use AlecRabbit\Spinner\Extras\Procedure\PercentageSymbolIndex;
use AlecRabbit\Spinner\Extras\Procedure\PercentGradientProcedure;
use AlecRabbit\Spinner\Extras\Procedure\PercentSequenceProcedure;
use AlecRabbit\Spinner\Extras\Procedure\PercentValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\TimerProcedure;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Value\PercentWrapper;
use AlecRabbit\Spinner\Extras\Value\TimerValue;
use AlecRabbit\Spinner\Extras\Value\ValueReference;

require_once __DIR__ . '/../bootstrap.async.php';

$updateInterval = 500; // milliseconds

$loadValue = new PercentWrapper();
$loadSymbolIndex = new PercentageSymbolIndex(percentValue: $loadValue);
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

$target = new DateTimeImmutable( '+110 seconds');

$timerValue = new TimerValue($target);

$timerReference = new ValueReference($timerValue);
$loadReference = new ValueReference($loadValue);

$loadWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            stylePalette: new PercentGradientProcedure(
                reference: $loadReference,
                gradient: $gradient,
                options: $options,
            ),
            charPalette: new PercentValueProcedure(
                reference: $loadReference,
                options: $options,
            ),
        ),
        new WidgetSettings(
            stylePalette: new PercentGradientProcedure(
                reference: $loadReference,
                gradient: $gradientTwo,
            ),
            charPalette: new PercentSequenceProcedure(
                reference: $loadSymbolIndex,
                size: $size,
                options: $options,
            ),
        ),
        new WidgetSettings(
            charPalette: new TimerProcedure(
                reference: $timerReference,
                intervalFormatter: new ClockDateIntervalFormatter(),
                format: '[%s]',
            ),
        ),
        new WidgetSettings(
            charPalette: new TimerProcedure(
                reference: $timerReference,
                intervalFormatter: new EstimateDateIntervalFormatter(),
                format: '[%s]',
            ),
        ),
        new WidgetSettings(
            charPalette: new TimerProcedure(
                reference: $timerReference,
                intervalFormatter: new FineDateIntervalFormatter(),
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
