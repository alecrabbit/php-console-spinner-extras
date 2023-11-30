<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;

interface IStyleToAnsiStringConverterFactory
{
    public function create(StylingMethodOption $styleMode): IStyleToAnsiStringConverter;
}
