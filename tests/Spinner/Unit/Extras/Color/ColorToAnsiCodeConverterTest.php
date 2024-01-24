<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color;

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Spinner\Extras\Color\AnsiCode;
use AlecRabbit\Spinner\Extras\Color\ColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Contract\IHexColorNormalizer;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ColorToAnsiCodeConverterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(ColorToAnsiCodeConverter::class, $converter);
    }

    public function getTesteeInstance(
        ?IHexColorNormalizer $hexColorNormalizer = null,
        ?IColorCodesGetter $colorCodesGetter = null,
    ): IColorToAnsiCodeConverter {
        return new ColorToAnsiCodeConverter(
            hexColorNormalizer: $hexColorNormalizer ?? $this->getHexColorNormalizerMock(),
            colorCodesGetter: $colorCodesGetter ?? $this->getColorCodesGetterMock(),

        );
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
    public function canConvert(): void
    {
        $r = 1;
        $g = 12;
        $b = 123;

        $color = $this->getHexColorMock();
        $color
            ->expects(self::once())
            ->method('getRed')
            ->willReturn($r)
        ;
        $color
            ->expects(self::once())
            ->method('getGreen')
            ->willReturn($g)
        ;
        $color
            ->expects(self::once())
            ->method('getBlue')
            ->willReturn($b)
        ;

        $hexColorNormalizer = $this->getHexColorNormalizerMock();
        $hexColorNormalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($color)
            ->willReturn($color)
        ;

        $colorCodesGetter = $this->getColorCodesGetterMock();
        $colorCodesGetter
            ->expects(self::once())
            ->method('getCodes')
            ->with($r, $g, $b)
            ->willReturn([1, 2, 3])
        ;

        $converter = $this->getTesteeInstance(
            hexColorNormalizer: $hexColorNormalizer,
            colorCodesGetter: $colorCodesGetter,
        );

        $actual = $converter->convert($color);

        self::assertInstanceOf(AnsiCode::class, $actual);
        self::assertSame('1;2;3', $actual->toString());
    }

    private function getHexColorMock(): MockObject&IHexColor
    {
        return $this->createMock(IHexColor::class);
    }

    private function getAnsi4DegraderMock(): MockObject&IAnsi4ColorDegrader
    {
        return $this->createMock(IAnsi4ColorDegrader::class);
    }

    private function getAnsi8DegraderMock(): MockObject&IAnsi8ColorDegrader
    {
        return $this->createMock(IAnsi8ColorDegrader::class);
    }
}
