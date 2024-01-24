<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptionsParser;
use AlecRabbit\Spinner\Extras\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\StyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Extras\StyleToAnsiStringConverter;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleToAnsiStringConverterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $converterFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleToAnsiStringConverterFactory::class, $converterFactory);
    }

    public function getTesteeInstance(
        ?IAnsiColorParserFactory $parserFactory = null,
        ?IStyleOptionsParser $optionsParser = null,
    ): IStyleToAnsiStringConverterFactory {
        return new StyleToAnsiStringConverterFactory(
            parserFactory: $parserFactory ?? $this->getAnsiColorParserFactoryMock(),
            optionsParser: $optionsParser ?? $this->getStyleOptionsParserMock(),
        );
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $colorParser = $this->getAnsiColorParserMock();
        $optionsParser = $this->getStyleOptionsParserMock();
        $parserFactory = $this->getAnsiColorParserFactoryMock();
        $parserFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($colorParser)
        ;

        $converterFactory = $this->getTesteeInstance(
            parserFactory: $parserFactory,
            optionsParser: $optionsParser,
        );

        $converter = $converterFactory->create();
        self::assertInstanceOf(StyleToAnsiStringConverterFactory::class, $converterFactory);
        self::assertInstanceOf(StyleToAnsiStringConverter::class, $converter);
    }
}
