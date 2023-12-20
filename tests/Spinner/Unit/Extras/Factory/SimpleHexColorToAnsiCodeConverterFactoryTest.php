<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Color\SimpleHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\SimpleHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SimpleHexColorToAnsiCodeConverterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $stylingMode = StylingMethodMode::NONE;

        $outputConfig = $this->getOutputConfigMock();
        $outputConfig
            ->expects(self::once())
            ->method('getStylingMethodMode')
            ->willReturn($stylingMode)
        ;

        $factory = $this->getTesteeInstance(
            outputConfig: $outputConfig,
        );

        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverterFactory::class, $factory);
    }

    private function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    public function getTesteeInstance(
        ?IOutputConfig $outputConfig = null,
    ): IHexColorToAnsiCodeConverterFactory {
        return new SimpleHexColorToAnsiCodeConverterFactory(
            outputConfig: $outputConfig ?? $this->getOutputConfigMock(),
        );
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $stylingMode = StylingMethodMode::ANSI24;

        $outputConfig = $this->getOutputConfigMock();
        $outputConfig
            ->expects(self::once())
            ->method('getStylingMethodMode')
            ->willReturn($stylingMode)
        ;
        $converterFactory = $this->getTesteeInstance(
            outputConfig: $outputConfig,
        );

        $converter = $converterFactory->create();
        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverterFactory::class, $converterFactory);
        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverter::class, $converter);
    }

    #[Test]
    public function throwsOnUnsupportedStyleMode(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage = 'Unsupported style mode "NONE".';

        $test = function (): void {
            $stylingMode = StylingMethodMode::NONE;

            $outputConfig = $this->getOutputConfigMock();
            $outputConfig
                ->expects(self::once())
                ->method('getStylingMethodMode')
                ->willReturn($stylingMode)
            ;

            $converterFactory = $this->getTesteeInstance(
                outputConfig: $outputConfig,
            );

            $converter = $converterFactory->create(StylingMethodMode::NONE);
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
