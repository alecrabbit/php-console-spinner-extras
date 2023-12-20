<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Extras\Color\SimpleHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Contract\IHexColorToAnsiCodeConverter;

final class SimpleHexColorToAnsiCodeConverterFactory implements Contract\IHexColorToAnsiCodeConverterFactory
{
    private StylingMethodMode $styleMode;

    public function __construct(
        IOutputConfig $outputConfig,
    ) {
        $this->styleMode = $outputConfig->getStylingMethodMode();
    }

    public function create(): IHexColorToAnsiCodeConverter
    {
        return new SimpleHexColorToAnsiCodeConverter($this->styleMode);
    }
}
