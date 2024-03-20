<?php

declare(strict_types=1);

use AlecRabbit\Benchmark\Factory\ReportFactory;
use AlecRabbit\Color\Gradient\ColorRange;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Lib\Spinner\BenchmarkFacade;
use AlecRabbit\Lib\Spinner\Contract\IBenchmarkingDriver;
use AlecRabbit\Spinner\Asynchronous\React\ReactLoopProbe;
use AlecRabbit\Spinner\Contract\Option\StylingOption;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Probes;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Extras\ClockDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\Moon;
use AlecRabbit\Spinner\Extras\Procedure\PercentGradientProcedure;
use AlecRabbit\Spinner\Extras\Procedure\PercentValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressBarProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressElapsedProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressEstimateProcedure;
use AlecRabbit\Spinner\Extras\Procedure\ProgressStepsProcedure;
use AlecRabbit\Spinner\Extras\Procedure\TimerProcedure;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Value\ProgressWrapper;
use AlecRabbit\Spinner\Extras\Value\TimerValue;
use AlecRabbit\Spinner\Extras\Value\ValueReference;

// in seconds
const RUNTIME = 600;
const MEMORY_REPORT_INTERVAL = 60;

require __DIR__ . '/../container.php';

// Pick ONE of the following event loops:
Probes::unregister(ReactLoopProbe::class);
//Probes::unregister(\AlecRabbit\Spinner\Asynchronous\Revolt\RevoltLoopProbe::class);

Facade::getSettings()
    ->set(
        new OutputSettings(
            stylingOption: StylingOption::ANSI24,
        ),
        new AlecRabbit\Spinner\Core\Settings\NormalizerSettings(
            normalizerOption: AlecRabbit\Spinner\Contract\Option\NormalizerOption::SMOOTH,
        ),
    )
;

$driver = Facade::getDriver();

if (!$driver instanceof IBenchmarkingDriver) {
    throw new LogicException(
        sprintf(
            'Driver must implement "%s".',
            IBenchmarkingDriver::class
        )
    );
}

$benchmarkResultsFactory = BenchmarkFacade::getBenchmarkResultsFactory();

$benchmarkResults =
    $benchmarkResultsFactory
        ->create(
            $driver
                ->getBenchmark()
                ->getMeasurements()
        )
;

$reportPrinter = BenchmarkFacade::getReportPrinter();

$reportObject =
    (new ReportFactory(benchmarkResults: $benchmarkResults, title: 'Benchmarking'))
        ->create()
;

$fullReport =
    static function () use ($reportPrinter, $reportObject): void {
        $reportPrinter->print($reportObject);
    };

$loop = Facade::getLoop();

// Stop loop after RUNTIME seconds
$loop
    ->delay(
        RUNTIME - 0.1,
        static function () use ($driver, $loop, $fullReport): void {
            $loop->stop();
            $driver->finalize();
            $fullReport();
        }
    )
;

/** ******************************************************** */
/** ******************************************************** */
/** ******************************************************** */
$units = 100;
$steps = 25000;

// Note: We'll use the same progress value for both widgets
$progressValue =
    new ProgressWrapper(
        steps: $steps,
    );

$progressReference = new ValueReference($progressValue);

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
            charPalette: new Moon(options: new PaletteOptions(interval: 10)),
        ),
        new WidgetSettings(
            charPalette: new ProgressStepsProcedure(
                reference: $progressReference,
                format: '%2s/%2s',
                options: new PaletteOptions(interval: 10),
            ),
        ),
        new WidgetSettings(
            stylePalette: new PercentGradientProcedure(
                reference: $progressReference,
                gradient: $gradientOne,

            ),
            charPalette: new ProgressBarProcedure(
                reference: $progressReference,
                units: $units,
            ),
        ),
        new WidgetSettings(
            charPalette: new PercentValueProcedure(
                reference: $progressReference,
            ),
        ),
    );

$progressWidgetTwoSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            charPalette: new ProgressElapsedProcedure(
                reference: $progressReference,
                format: '🕐 [%6s]',
            ),
        ),
        new WidgetSettings(
            stylePalette: new PercentGradientProcedure(
                reference: $progressReference,
                gradient: $gradientTwo,
            ),
            charPalette: new ProgressEstimateProcedure(
                reference: $progressReference,
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

$target = new DateTimeImmutable('+' . RUNTIME . ' seconds');

$timerReference = new ValueReference(new TimerValue($target));

/** @var IWidgetComposite $timer */
$timer =
    Facade::getWidgetFactory()
        ->usingSettings(
            new WidgetSettings(
                stylePalette: new PercentGradientProcedure(
                    reference: $progressReference,
                    gradient: $gradientTwo,
                ),
                charPalette: new TimerProcedure(
                    reference: $timerReference,
                    intervalFormatter: new ClockDateIntervalFormatter(),
                    format: '[%s]',
                ),
            )
        )
        ->create()
;

$spinner = Facade::createSpinner();

$spinner->add($timer->getContext());
$spinner->add($widgetOne->getContext());
$spinner->add($widgetTwo->getContext());

$loop = Facade::getLoop();

// simulate progress
$loop
    ->repeat(
        0.01,
        static function () use ($progressValue): void {
            if (random_int(0, 100) < 80) {
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

// Remove spinner before loop stops
$loop
    ->delay(
        RUNTIME - 0.2,
        static function () use ($driver, $spinner): void {
            $driver->remove($spinner);
        }
    )
;

// Begin benchmarking
echo sprintf('Runtime: %ss', RUNTIME) . PHP_EOL;