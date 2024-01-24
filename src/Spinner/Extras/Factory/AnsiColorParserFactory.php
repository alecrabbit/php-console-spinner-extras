<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Color\AnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorToAnsiCodeConverterFactory;

final class AnsiColorParserFactory implements IAnsiColorParserFactory
{
    public function __construct(
        protected IColorToAnsiCodeConverterFactory $converterFactory,
    ) {
    }

    public function create(): IAnsiColorParser
    {
        return new AnsiColorParser(
            converter: $this->converterFactory->create(),
        );
    }
}
