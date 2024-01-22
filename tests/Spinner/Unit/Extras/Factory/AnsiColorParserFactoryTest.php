<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Color\AnsiColorParser;
use AlecRabbit\Spinner\Extras\Factory\AnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class AnsiColorParserFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $parserFactory = $this->getTesteeInstance();

        self::assertInstanceOf(AnsiColorParserFactory::class, $parserFactory);
    }

    public function getTesteeInstance(
        ?IHexColorToAnsiCodeConverterFactory $converterFactory = null,
    ): IAnsiColorParserFactory {
        return new AnsiColorParserFactory(
            converterFactory: $converterFactory ?? $this->getHexColorToAnsiCodeConverterFactoryMock(),
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $parserFactory = $this->getTesteeInstance();

        self::assertInstanceOf(AnsiColorParserFactory::class, $parserFactory);
        self::assertInstanceOf(
            AnsiColorParser::class,
            $parserFactory->create(StylingMethodMode::ANSI8)
        );
    }
}
