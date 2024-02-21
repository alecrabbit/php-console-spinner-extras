<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\A\AInfiniteCharPalette;
use RuntimeException;
use Traversable;

final class CustomCharPalette extends ACharPalette
{
    public function __construct(
        \ArrayObject $frames,
        IPaletteOptions $options = new PaletteOptions(),
        int $index = 0,
    ) {
        parent::__construct($frames, $options, $index);
    }
}
