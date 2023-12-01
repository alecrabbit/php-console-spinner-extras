<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgument;

interface IHexColorToAnsiCodeConverter
{
    /**
     * @throws InvalidArgument
     */
    public function convert(string $color): string;
}
