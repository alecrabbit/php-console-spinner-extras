<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Color\SimpleHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\SimpleHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SimpleHexColorToAnsiCodeConverterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $converterFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverterFactory::class, $converterFactory);
    }

    public function getTesteeInstance(): IHexColorToAnsiCodeConverterFactory
    {
        return new SimpleHexColorToAnsiCodeConverterFactory();
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $converterFactory = $this->getTesteeInstance();

        $converter = $converterFactory->create(StylingMethodOption::ANSI4);
        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverterFactory::class, $converterFactory);
        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverter::class, $converter);
    }

    #[Test]
    public function throwsOnUnsupportedStyleMode(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage = 'Unsupported style mode "NONE".';

        $test = function (): void {
            $converterFactory = $this->getTesteeInstance();

            $converter = $converterFactory->create(StylingMethodOption::NONE);
            self::assertInstanceOf(SimpleHexColorToAnsiCodeConverterFactory::class, $converterFactory);
            self::assertInstanceOf(SimpleHexColorToAnsiCodeConverter::class, $converter);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
