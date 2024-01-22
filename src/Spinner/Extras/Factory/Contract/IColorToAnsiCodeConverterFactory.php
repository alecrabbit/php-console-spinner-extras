<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;

interface IColorToAnsiCodeConverterFactory
{
    public function create(StylingMethodMode $styleMode): IColorToAnsiCodeConverter;
}