<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Frame;

use AlecRabbit\Spinner\Core\A\AFrame;
use AlecRabbit\Spinner\Extras\Contract\IStylingFrame;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

final readonly class StylingFrame extends AFrame implements IStylingFrame
{
    public function __construct(
        string $sequence,
        int $width,
        private IStyle $style,
    ) {
        parent::__construct(
            sequence: $sequence,
            width: $width
        );
    }

    public function getStyle(): IStyle
    {
        return $this->style;
    }
}
