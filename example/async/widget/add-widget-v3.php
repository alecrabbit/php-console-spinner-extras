<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\PulseOrangeBlue;
use AlecRabbit\Spinner\Extras\Palette\Char\ShortSnake;
use AlecRabbit\Spinner\Extras\Palette\Style\Red;

require_once __DIR__ . '/../bootstrap.async.php';

// !! ATTENTION !! Cursor movement is used in this example

Facade::getSettings()
    ->set(
        new OutputSettings(
            cursorVisibilityOption: CursorVisibilityOption::VISIBLE,
        )
    )
;
/** @var IWidgetComposite $widget */
$widget =
    Facade::getWidgetFactory()
        ->usingSettings(
            new WidgetSettings(
                trailingSpacer: new CharSequenceFrame('  ', 2), // move cursor up
                charPalette: new ShortSnake(),
            )
        )
        ->create()
;

/** @var IWidgetComposite $widgetTwo */
$widgetTwo =
    Facade::getWidgetFactory()
        ->usingSettings(
            new WidgetSettings(
                leadingSpacer: new CharSequenceFrame("\x1b[1D", -1), // move cursor backward
                charPalette: new PulseOrangeBlue(),
            )
        )
        ->create()
;

$widget->add($widgetTwo->getContext()); // note the nesting

$spinner =
    Facade::createSpinner(
        new SpinnerSettings(
            new WidgetSettings(
                leadingSpacer: new CharSequenceFrame("\x1b[3C", 3), // move cursor forward
                stylePalette: new Red()
            )
        ),
    );

$spinner->add($widget->getContext());
