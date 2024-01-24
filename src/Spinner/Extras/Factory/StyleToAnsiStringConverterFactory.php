<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptionsParser;
use AlecRabbit\Spinner\Extras\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Extras\StyleToAnsiStringConverter;

final class StyleToAnsiStringConverterFactory implements IStyleToAnsiStringConverterFactory
{
    public function __construct(
        protected IAnsiColorParserFactory $parserFactory,
        protected IStyleOptionsParser $optionsParser,
    ) {
    }

    public function create(): IStyleToAnsiStringConverter
    {
        return new StyleToAnsiStringConverter(
            colorParser: $this->parserFactory->create(),
            optionsParser: $this->optionsParser,
        );
    }
}
