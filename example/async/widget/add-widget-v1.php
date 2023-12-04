<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\FeatheredArrow;

require_once __DIR__ . '/../bootstrap.async.php';

Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            stylePalette: new NoStylePalette(),
        )
    )
;

/** @var IWidgetComposite $widget */
$widget =
    Facade::getWidgetFactory()
        ->create(
            new WidgetSettings(
                stylePalette: new Rainbow(),
                charPalette: new FeatheredArrow(
                    new PaletteOptions
                    (
                        interval: 1000,
                        reversed: false
                    )
                )
            )
        )
;

$spinner = Facade::createSpinner();

$spinner->add($widget->getContext());
