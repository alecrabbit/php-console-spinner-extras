## Progress Widgets

> **Note:** This is a work in progress. The API is not stable.

```php
$factory = Facade::getProgressWidgetFactory();

$widgetSettings = 
    new WidgetSettings(
        stylePalette: /* TBD */,
        charPalette: /* TBD */,
    );

$progressValue = new ProgressValue(0);

$widget = $factory->create($progressValue, $widgetSettings);

$spinner = Facade::createSpinner();

$spinner->add($widget->getContext());
```
