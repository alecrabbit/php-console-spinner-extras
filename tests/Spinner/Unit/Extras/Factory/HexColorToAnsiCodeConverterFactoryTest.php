<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Extras\Color\HexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\HexColorToAnsiCodeConverterFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class HexColorToAnsiCodeConverterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
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

        self::assertInstanceOf(HexColorToAnsiCodeConverterFactory::class, $factory);
    }

    private function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    public function getTesteeInstance(
        ?IOutputConfig $outputConfig = null,
    ): IHexColorToAnsiCodeConverterFactory {
        return new HexColorToAnsiCodeConverterFactory(
            outputConfig: $outputConfig ?? $this->getOutputConfigMock(),
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $stylingMode = StylingMethodMode::ANSI24;

        $outputConfig = $this->getOutputConfigMock();
        $outputConfig
            ->expects(self::once())
            ->method('getStylingMethodMode')
            ->willReturn($stylingMode)
        ;

        $factory = $this->getTesteeInstance(
            outputConfig: $outputConfig,
        );

        self::assertInstanceOf(HexColorToAnsiCodeConverterFactory::class, $factory);

        $result = $factory->create();

        self::assertInstanceOf(HexColorToAnsiCodeConverter::class, $result);
    }
}
