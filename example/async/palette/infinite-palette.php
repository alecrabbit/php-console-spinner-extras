<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteStylePalette;

require_once __DIR__ . '/../bootstrap.async.php';

$stylePalette =
    new class() extends AInfiniteStylePalette {
        protected function ansi4StyleFrames(): Traversable
        {
            $a = [
                "\e[30m%s\e[39m",
                "\e[31m%s\e[39m",
                "\e[32m%s\e[39m",
                "\e[33m%s\e[39m",
                "\e[34m%s\e[39m",
                "\e[35m%s\e[39m",
                "\e[36m%s\e[39m",
                "\e[37m%s\e[39m",
                "\e[90m%s\e[39m",
                "\e[91m%s\e[39m",
                "\e[92m%s\e[39m",
                "\e[93m%s\e[39m",
                "\e[94m%s\e[39m",
                "\e[95m%s\e[39m",
                "\e[96m%s\e[39m",
                "\e[97m%s\e[39m",
            ];
            $count = count($a);

            while (true) {
                yield $a[random_int(0, $count - 1)];
            }
        }

        protected function modeInterval(?IPaletteMode $mode = null): ?int
        {
            return 100;
        }

        protected function createFrame(string $element, ?int $width = null): IStyleFrame
        {
            return new StyleFrame($element, $width ?? 0);
        }
    };

$charPalette = new class() extends AInfiniteCharPalette {
    protected function sequence(): Traversable
    {
        $a = [
            '⠏',
            '⠛',
            '⠹',
            '⢸',
            '⣰',
            '⣤',
            '⣆',
            '⡇',
            new CharFrame(' ⠏', 2),
            new CharFrame(' ⠛', 2),
            new CharFrame(' ⠹', 2),
            new CharFrame(' ⢸', 2),
            new CharFrame(' ⣰', 2),
            new CharFrame(' ⣤', 2),
            new CharFrame(' ⣆', 2),
            new CharFrame(' ⡇', 2),
        ];
        $count = count($a);

        while (true) {
            yield $a[random_int(0, $count - 1)];
        }
    }

    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? 1);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 100;
    }
};


Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            stylePalette: $stylePalette,
            charPalette: $charPalette,
        ),
    )
;

$spinner = Facade::createSpinner();
