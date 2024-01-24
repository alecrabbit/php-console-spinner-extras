<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Builder\Contract;

use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;

interface IColorToAnsiCodeConverterBuilder
{
    public function build(): IColorToAnsiCodeConverter;
}
