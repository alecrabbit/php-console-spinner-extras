<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\Char\Dice;
use AlecRabbit\Spinner\Extras\Palette\Char\FeatheredArrow;
use AlecRabbit\Spinner\Extras\Palette\Char\ShortSnake;
use AlecRabbit\Spinner\Extras\Settings\MultiWidgetSettings;

require_once __DIR__ . '/../bootstrap.async.php';

$widgetSettings =
    new MultiWidgetSettings(
        new WidgetSettings(
            stylePalette: new Rainbow(),
            charPalette: new Dice()
        ),
        new WidgetSettings(
            stylePalette: new Rainbow(),
            charPalette: new FeatheredArrow()
        ),
        new WidgetSettings(
            stylePalette: new Rainbow(),
            charPalette: new FeatheredArrow()
        ),
        new WidgetSettings(
            stylePalette: new Rainbow(),
            charPalette: new FeatheredArrow()
        ),
        new WidgetSettings(
            stylePalette: new Rainbow(),
            charPalette: new FeatheredArrow()
        ),
        new WidgetSettings(
            stylePalette: new NoStylePalette(),
            charPalette: new ShortSnake()
        ),
    );

/** @var IWidgetComposite $widget */
$widget =
    Facade::getWidgetFactory()
        ->usingSettings(
            $widgetSettings
        )
        ->create()
;

$spinner = Facade::createSpinner();

$spinner->add($widget->getContext());
