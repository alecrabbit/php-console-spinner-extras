<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;


use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Extras\Color\IHexColorNormalizer;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\ColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorCodesGetterFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorToAnsiCodeConverterFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ColorToAnsiCodeConverterFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(ColorToAnsiCodeConverterFactory::class, $converter);
    }

    private function getTesteeInstance(
        ?IOutputConfig $outputConfig = null,
        ?IHexColorNormalizer $hexColorNormalizer = null,
        ?IColorCodesGetterFactory $colorCodesGetterFactory = null,
    ): IColorToAnsiCodeConverterFactory
    {
        return new ColorToAnsiCodeConverterFactory(
            outputConfig: $outputConfig ?? $this->getOutputConfigMock(),
            hexColorNormalizer: $hexColorNormalizer ?? $this->getHexColorNormalizerMock(),
            colorCodesGetterFactory: $colorCodesGetterFactory ?? $this->getColorCodesGetterFactoryMock(),
        );
    }

    private function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    private function getHexColorNormalizerMock(): MockObject&IHexColorNormalizer
    {
        return $this->createMock(IHexColorNormalizer::class);
    }

    private function getColorCodesGetterFactoryMock(): MockObject&IColorCodesGetterFactory
    {
        return $this->createMock(IColorCodesGetterFactory::class);
    }
}
