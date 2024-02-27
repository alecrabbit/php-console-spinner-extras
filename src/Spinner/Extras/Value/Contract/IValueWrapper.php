<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value\Contract;

interface IValueWrapper
{
    public function unwrap(): mixed;
}
