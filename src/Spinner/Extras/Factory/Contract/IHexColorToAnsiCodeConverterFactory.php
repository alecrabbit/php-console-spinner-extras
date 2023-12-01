<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;

interface IHexColorToAnsiCodeConverterFactory
{
    public function create(StylingMethodOption $styleMode): IHexColorToAnsiCodeConverter;
}
