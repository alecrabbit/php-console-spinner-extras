<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color\Contract;

interface IAnsi8ColorDegrader
{
    public function degrade(int $r, int $g, int $b): int;
}
