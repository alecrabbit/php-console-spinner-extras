<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Color\AnsiColorParser;
use AlecRabbit\Spinner\Extras\Factory\AnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IAnsiColorParserFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorToAnsiCodeConverterFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class AnsiColorParserFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $parserFactory = $this->getTesteeInstance();

        self::assertInstanceOf(AnsiColorParserFactory::class, $parserFactory);
    }

    public function getTesteeInstance(
        ?IColorToAnsiCodeConverterFactory $converterFactory = null,
    ): IAnsiColorParserFactory {
        return new AnsiColorParserFactory(
            converterFactory: $converterFactory ?? $this->getHexColorToAnsiCodeConverterFactoryMock(),
        );
    }

    private function getHexColorToAnsiCodeConverterFactoryMock(): MockObject&IColorToAnsiCodeConverterFactory
    {
        return $this->createMock(IColorToAnsiCodeConverterFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $parserFactory = $this->getTesteeInstance();
        $parser = $parserFactory->create(StylingMethodMode::ANSI8);

        self::assertInstanceOf(AnsiColorParserFactory::class, $parserFactory);
        self::assertInstanceOf(AnsiColorParser::class, $parser);
    }
}
