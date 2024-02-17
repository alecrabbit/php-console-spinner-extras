<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use RuntimeException;
use Traversable;

/**
 * @codeCoverageIgnore
 * @psalm-suppress UnusedClass
 */
final class StormyWeather extends ACharPalette
{
    public function unwrap(?IPaletteMode $mode = null): IPaletteTemplate
    {
        // TODO: Implement unwrap() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }

    protected function sequence(): Traversable
    {
        yield from [
            '☀️ ',
            '☀️ ',
            '🌤 ',
            '🌤 ',
            '🌤 ',
            '⛅️',
            '⛅️',
            '🌥 ',
            '🌥 ',
            '☁️ ',
            '☁️ ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌩️ ',
            '🌨 ',
            '🌩️ ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌩️ ',
            '🌩️ ',
            '🌨 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '🌨 ',
            '🌧 ',
            '☁️ ',
            '☁️ ',
            '🌥 ',
            '🌥 ',
            '⛅️',
            '⛅️',
            '🌤 ',
            '🌤 ',
            '🌤 ',
            '☀️ ',
            '☀️ ',
        ];
    }

    protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame
    {
        return new CharFrame($element, $width ?? 2);
    }

    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return 80;
    }
}
