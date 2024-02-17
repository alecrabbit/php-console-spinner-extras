<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Frame;

use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Contract\IStyleFrame;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

final readonly class StyleFrame implements IStyleFrame
{
    public function __construct(
        private IStyle $style,
    ) {
    }

    public function getStyle(): IStyle
    {
        return $this->style;
    }

    public function getSequence(): string
    {
        throw new LogicException('Should not be called.');
    }

    public function getWidth(): int
    {
        throw new LogicException('Should not be called.');
    }
}
