<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

interface IWidthGetter
{
    public function getWidth(string $string): int;
}
