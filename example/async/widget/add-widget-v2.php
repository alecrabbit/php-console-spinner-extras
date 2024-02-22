<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\DotBinaryCount;

require_once __DIR__ . '/../bootstrap.async.php';

/** @var IWidgetComposite $widget */
$widget =
    Facade::getWidgetFactory()
        ->usingSettings(
            new WidgetSettings(
                trailingSpacer: new CharSequenceFrame('', 0),
            ),
        )
        ->create()
;

/** @var IWidgetComposite $widgetTwo */
$widgetTwo =
    Facade::getWidgetFactory()
        ->usingSettings(
            new WidgetSettings(
                trailingSpacer: new CharSequenceFrame(' 🎊', 3),
                stylePalette: new Rainbow(),
                charPalette: new DotBinaryCount(
                    options: new PaletteOptions(interval: 10),
                ),
            )
        )
        ->create()
;

$spinner = Facade::createSpinner();

$spinner->add($widget->getContext());

$widget->add($widgetTwo->getContext()); // note the nesting
