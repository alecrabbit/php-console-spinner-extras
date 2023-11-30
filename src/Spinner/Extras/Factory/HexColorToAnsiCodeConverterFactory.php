<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Extras\Color\HexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;

final class HexColorToAnsiCodeConverterFactory implements IHexColorToAnsiCodeConverterFactory
{
    public function create(StylingMethodOption $styleMode): IHexColorToAnsiCodeConverter
    {
        return new HexColorToAnsiCodeConverter($styleMode);
    }
}
