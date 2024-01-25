<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color\Builder;


use AlecRabbit\Spinner\Extras\Color\Builder\ColorToAnsiCodeConverterBuilder;
use AlecRabbit\Spinner\Extras\Color\Builder\Contract\IColorToAnsiCodeConverterBuilder;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Contract\IHexColorNormalizer;
use AlecRabbit\Tests\TestCase\TestCase;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ColorToAnsiCodeConverterBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(ColorToAnsiCodeConverterBuilder::class, $builder);
    }

    private function getTesteeInstance(): IColorToAnsiCodeConverterBuilder
    {
        return new ColorToAnsiCodeConverterBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $builder
            ->withHexColorNormalizer($this->getHexColorNormalizerMock())
            ->withColorCodesGetter($this->getColorCodesGetterMock())
            ->build()
        ;

        self::assertTrue(true);
    }

    private function getHexColorNormalizerMock(): MockObject&IHexColorNormalizer
    {
        return $this->createMock(IHexColorNormalizer::class);
    }

    private function getColorCodesGetterMock(): MockObject&IColorCodesGetter
    {
        return $this->createMock(IColorCodesGetter::class);
    }

    #[Test]
    public function throwsIfHexColorNormalizerIsNotSet(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('HexColorNormalizer is not set.');

        $builder = $this->getTesteeInstance();

        $builder
            ->withColorCodesGetter($this->getColorCodesGetterMock())
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfColorCodesGetterIsNotSet(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('ColorCodesGetter is not set.');

        $builder = $this->getTesteeInstance();

        $builder
            ->withHexColorNormalizer($this->getHexColorNormalizerMock())
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }
}
