<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Extras\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\Clock;
use AlecRabbit\Spinner\Extras\Palette\Char\Diamond;
use AlecRabbit\Spinner\Extras\Palette\Char\Dice;
use AlecRabbit\Spinner\Extras\Palette\Char\Dot;
use AlecRabbit\Spinner\Extras\Palette\Char\FeatheredArrow;
use AlecRabbit\Spinner\Extras\Palette\Char\Runner;
use AlecRabbit\Spinner\Extras\Palette\Char\ShortSnake;
use AlecRabbit\Spinner\Extras\Palette\Char\StormyWeather;
use AlecRabbit\Spinner\Extras\Procedure\Red;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;

require_once __DIR__ . '/../bootstrap.async.php';

$multiWidgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            stylePalette: new Red(),
            charPalette: new Dice()
        ),
        new WidgetSettings(
            stylePalette: new Rainbow(),
            charPalette: new FeatheredArrow()
        ),
        new WidgetSettings(
            charPalette: new Runner()
        ),
        new WidgetSettings(
            charPalette: new ShortSnake()
        ),
        new WidgetSettings(
            charPalette: new Clock()
        ),
        new WidgetSettings(
            charPalette: new StormyWeather(),
        ),
    );


/** @var IWidgetComposite $widget */
$widget =
    Facade::getWidgetFactory()
        ->usingSettings(
            $multiWidgetSettings
        )
        ->create()
;

Facade::createSpinner()->add($widget->getContext());
