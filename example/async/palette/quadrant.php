<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\Quadrant;

require_once __DIR__ . '/../bootstrap.async.php';

Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            charPalette: new Quadrant(),
        )
    )
;

$spinner = Facade::createSpinner();
