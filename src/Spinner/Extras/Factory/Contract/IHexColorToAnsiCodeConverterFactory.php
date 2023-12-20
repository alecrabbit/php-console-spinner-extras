<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;

interface IHexColorToAnsiCodeConverterFactory
{
    public function create(StylingMethodMode $styleMode): IHexColorToAnsiCodeConverter;
}
