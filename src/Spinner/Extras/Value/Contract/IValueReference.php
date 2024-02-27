<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Value\Contract;

interface IValueReference
{
    public function getWrapper(): IValueWrapper;
}
