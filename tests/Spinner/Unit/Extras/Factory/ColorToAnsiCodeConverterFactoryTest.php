<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;


use AlecRabbit\Spinner\Extras\Color\Builder\Contract\IColorToAnsiCodeConverterBuilder;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Contract\IHexColorNormalizer;
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
        ?IHexColorNormalizer $hexColorNormalizer = null,
        ?IColorCodesGetterFactory $colorCodesGetterFactory = null,
        ?IColorToAnsiCodeConverterBuilder $colorToAnsiCodeConverterBuilder = null,
    ): IColorToAnsiCodeConverterFactory {
        return new ColorToAnsiCodeConverterFactory(
            hexColorNormalizer: $hexColorNormalizer ?? $this->getHexColorNormalizerMock(),
            colorCodesGetterFactory: $colorCodesGetterFactory ?? $this->getColorCodesGetterFactoryMock(),
            colorToAnsiCodeConverterBuilder: $colorToAnsiCodeConverterBuilder ?? $this->getColorToAnsiCodeConverterBuilderMock(
        ),
        );
    }

    private function getHexColorNormalizerMock(): MockObject&IHexColorNormalizer
    {
        return $this->createMock(IHexColorNormalizer::class);
    }

    private function getColorCodesGetterFactoryMock(): MockObject&IColorCodesGetterFactory
    {
        return $this->createMock(IColorCodesGetterFactory::class);
    }

    private function getColorToAnsiCodeConverterBuilderMock(): MockObject&IColorToAnsiCodeConverterBuilder
    {
        return $this->createMock(IColorToAnsiCodeConverterBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $converter = $this->createMock(IColorToAnsiCodeConverter::class);

        $colorCodesGetter = $this->getColorCodesGetterMock();
        $colorCodesGetterFactory = $this->getColorCodesGetterFactoryMock();
        $colorCodesGetterFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($colorCodesGetter)
        ;
        $hexColorNormalizer = $this->getHexColorNormalizerMock();

        $builder = $this->getColorToAnsiCodeConverterBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withHexColorNormalizer')
            ->with($hexColorNormalizer)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('withColorCodesGetter')
            ->with($colorCodesGetter)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($converter)
        ;

        $factory = $this->getTesteeInstance(
            hexColorNormalizer: $hexColorNormalizer,
            colorCodesGetterFactory: $colorCodesGetterFactory,
            colorToAnsiCodeConverterBuilder: $builder,
        );

        self::assertSame($converter, $factory->create());
    }

    private function getColorCodesGetterMock(): MockObject&IColorCodesGetter
    {
        return $this->createMock(IColorCodesGetter::class);
    }
}
