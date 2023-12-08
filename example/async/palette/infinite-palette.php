<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use AlecRabbit\Spinner\Extras\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$stylePalette =
    new class(new PaletteOptions()) extends AStylePalette implements IInfinitePalette {
        protected function ansi4StyleFrames(): Traversable
        {
            while (true) {
                yield $this->createFrame("\e[92m%s\e[39m");
                yield $this->createFrame("\e[31m%s\e[39m");
            }
        }

        protected function ansi8StyleFrames(): Traversable
        {
            return $this->ansi4StyleFrames();
        }

        protected function ansi24StyleFrames(): Traversable
        {
            return $this->ansi4StyleFrames();
        }

        protected function getInterval(StylingMethodMode $stylingMode): ?int
        {
            return 100;
        }
    };

Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            stylePalette: $stylePalette,
        ),
    )
;

$spinner = Facade::createSpinner(); // yep, that's it
