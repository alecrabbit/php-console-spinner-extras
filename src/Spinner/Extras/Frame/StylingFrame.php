<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Frame;

use AlecRabbit\Spinner\Core\A\AFrame;
use AlecRabbit\Spinner\Extras\Contract\IStylingFrame;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

final readonly class StylingFrame extends AFrame implements IStylingFrame
{
    public function __construct(
        private IStyle $style,
        ?string $sequence = null,
        ?int $width = null,
    ) {
        parent::__construct(
            sequence: $sequence ?? '%s',
            width: $width ?? 0,
        );
    }

    public function getStyle(): IStyle
    {
        return $this->style;
    }
}
