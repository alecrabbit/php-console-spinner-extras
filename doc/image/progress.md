## Progress Widgets

> **Note:** This is a work in progress. The API is not stable.

```php
$factory = Facade::getWidgetFactory();

$progressValue = new ProgressValue();

$widgetSettings = 
    new MultiWidgetSettings(
        new WidgetSettings(
            stylePalette: new ProgressStylePalette(/* TBD */),
            charPalette: new ProgressCharPalette(/* TBD */),
        ),
        new WidgetSettings(
            stylePalette: new ProgressStylePalette(/* TBD */),
            charPalette: new ProgressCharPalette(/* TBD */),
        ),
    );

$widget = 
    $factory
        ->usingSettings($widgetSettings)
        ->create();

$spinner = Facade::createSpinner();

$spinner->add($widget->getContext());
```
