<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;

final readonly class StyleRenderer implements IStyleRenderer
{
    public function __construct(
        private IStyleToAnsiStringConverter $converter,
    ) {
    }

    public function render(IStyle $style): string
    {
        if ($style->isEmpty()) {
            return '%s';
        }

        return $this->converter->convert($style);
    }
}
