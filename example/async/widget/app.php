<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Snake;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

/** @var IWidgetComposite $widget */
$widget =
    Facade::getWidgetFactory()
        ->create(
            new WidgetSettings(
                charPalette: new \AlecRabbit\Spinner\Extras\Palette\Char\Speaker(
                    new PaletteOptions(reversed: true)
                )
            )
        )
;

$spinner = Facade::createSpinner();

$spinner->add($widget->getContext());

$spinner->add($widget->getContext());
