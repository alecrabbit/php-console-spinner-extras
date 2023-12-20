<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;

use AlecRabbit\Spinner\Extras\Color\SimpleHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;

final class SimpleHexColorToAnsiCodeConverterFactory implements Contract\IHexColorToAnsiCodeConverterFactory
{
    public function create(StylingMethodMode $styleMode): IHexColorToAnsiCodeConverter
    {
        return new SimpleHexColorToAnsiCodeConverter($styleMode);
    }
}
