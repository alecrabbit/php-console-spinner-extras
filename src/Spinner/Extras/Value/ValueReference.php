<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value;

use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueWrapper;

final readonly class ValueReference implements IValueReference
{
    public function __construct(
        private IValueWrapper $value
    ) {
    }

    public function getWrapper(): IValueWrapper
    {
        return $this->value;
    }
}
