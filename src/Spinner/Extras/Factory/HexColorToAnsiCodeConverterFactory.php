<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Extras\Color\HexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;

final class HexColorToAnsiCodeConverterFactory implements IHexColorToAnsiCodeConverterFactory
{
    private StylingMethodMode $styleMode;

    public function __construct(
        IOutputConfig $outputConfig,
    )
    {
        $this->styleMode = $outputConfig->getStylingMethodMode();
    }

    public function create(): IHexColorToAnsiCodeConverter
    {
        return new HexColorToAnsiCodeConverter($this->styleMode);
    }
}
