<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;


use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Extras\Color\Ansi24ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi4ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi8ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Factory\ColorCodesGetterFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorCodesGetterFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ColorCodesGetterFactoryTest extends TestCase
{
    public static function canCreateDataProvider(): iterable
    {
        yield from [
            [Ansi4ColorCodesGetter::class, StylingMethodMode::ANSI4],
            [Ansi8ColorCodesGetter::class, StylingMethodMode::ANSI8],
            [Ansi24ColorCodesGetter::class, StylingMethodMode::ANSI24],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(ColorCodesGetterFactory::class, $factory);
    }

    private function getTesteeInstance(
        ?IOutputConfig $outputConfig = null,
    ): IColorCodesGetterFactory {
        return new ColorCodesGetterFactory(
            outputConfig: $outputConfig ?? $this->getOutputConfigMock(),
        );
    }

    private function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    #[Test]
    #[DataProvider('canCreateDataProvider')]
    public function canCreate(string $expectedClass, StylingMethodMode $stylingMode): void
    {
        $outputConfig = $this->getOutputConfigMock();
        $outputConfig
            ->expects(self::once())
            ->method('getStylingMethodMode')
            ->willReturn($stylingMode)
        ;

        $factory = $this->getTesteeInstance(outputConfig: $outputConfig);

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($expectedClass, $factory->create());
    }

    #[Test]
    public function throwsIfModeIsUnknown(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Unknown mode.');

        $outputConfig = $this->getOutputConfigMock();
        $outputConfig
            ->expects(self::once())
            ->method('getStylingMethodMode')
            ->willReturn(StylingMethodMode::NONE)
        ;

        $factory = $this->getTesteeInstance(outputConfig: $outputConfig);

        $factory->create();

        self::fail('Exception was not thrown.');
    }
}
