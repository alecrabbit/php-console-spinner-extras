<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;

final class StyleRenderer implements IStyleRenderer
{
    public function __construct(
        protected IStyleToAnsiStringConverter $converter,
    ) {
    }

    /**
     * @throws InvalidArgument
     */
    public function render(IStyle $style): string
    {
        if ($style->isEmpty()) {
            return '%s';
        }

        return $this->converter->convert($style);
    }
}
