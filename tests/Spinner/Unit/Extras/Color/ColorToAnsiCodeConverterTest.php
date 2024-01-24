<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color;

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Color\AnsiCode;
use AlecRabbit\Spinner\Extras\Color\ColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4BrightnessChecker;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\IHexColorNormalizer;
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
        ?StylingMethodMode $styleMode = null,
        ?IHexColorNormalizer $hexColorNormalizer = null,
        ?IAnsi4ColorDegrader $ansi4ColorDegrader = null,
        ?IAnsi8ColorDegrader $ansi8ColorDegrader = null,
    ): IColorToAnsiCodeConverter {
        return new ColorToAnsiCodeConverter(
            mode: $styleMode ?? StylingMethodMode::ANSI24,
            hexColorNormalizer: $hexColorNormalizer ?? $this->getHexColorNormalizerMock(),
            ansi4ColorDegrader: $ansi4ColorDegrader ?? $this->getAnsi4DegraderMock(),
            ansi8ColorDegrader: $ansi8ColorDegrader ?? $this->getAnsi8DegraderMock(),

        );
    }

    private function getHexColorNormalizerMock(): MockObject&IHexColorNormalizer
    {
        return $this->createMock(IHexColorNormalizer::class);
    }

    private function getAns4BrightnessCheckerMock(): MockObject&IAnsi4BrightnessChecker
    {
        return $this->createMock(IAnsi4BrightnessChecker::class);
    }

    private function getAnsi4DegraderMock(): MockObject&IAnsi4ColorDegrader
    {
        return $this->createMock(IAnsi4ColorDegrader::class);
    }

    private function getAnsi8DegraderMock(): MockObject&IAnsi8ColorDegrader
    {
        return $this->createMock(IAnsi8ColorDegrader::class);
    }

    #[Test]
    public function canConvertAnsi4(): void
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
        $ansi4ColorDegrader = $this->getAnsi4DegraderMock();
        $ansi8ColorDegrader = $this->getAnsi8DegraderMock();

        $hexColorNormalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($color)
            ->willReturn($color)
        ;

        $ansi4ColorDegrader
            ->expects(self::once())
            ->method('degrade')
            ->with($r, $g, $b)
            ->willReturn(0)
        ;

        $ansi8ColorDegrader
            ->expects(self::never())
            ->method('degrade')
        ;

        $converter = $this->getTesteeInstance(
            styleMode: StylingMethodMode::ANSI4,
            hexColorNormalizer: $hexColorNormalizer,
            ansi4ColorDegrader: $ansi4ColorDegrader,
            ansi8ColorDegrader: $ansi8ColorDegrader,
        );

        $actual = $converter->convert($color);

        self::assertInstanceOf(AnsiCode::class, $actual);
        self::assertSame('0', $actual->toString());
    }

    private function getHexColorMock(): MockObject&IHexColor
    {
        return $this->createMock(IHexColor::class);
    }

    #[Test]
    public function canConvertAnsi8(): void
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
        $ansi4ColorDegrader = $this->getAnsi4DegraderMock();
        $ansi8ColorDegrader = $this->getAnsi8DegraderMock();

        $hexColorNormalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($color)
            ->willReturn($color)
        ;

        $ansi4ColorDegrader
            ->expects(self::never())
            ->method('degrade')
        ;

        $ansi8ColorDegrader
            ->expects(self::once())
            ->method('degrade')
            ->with($r, $g, $b)
            ->willReturn(100)
        ;

        $converter = $this->getTesteeInstance(
            styleMode: StylingMethodMode::ANSI8,
            hexColorNormalizer: $hexColorNormalizer,
            ansi4ColorDegrader: $ansi4ColorDegrader,
            ansi8ColorDegrader: $ansi8ColorDegrader,
        );

        $actual = $converter->convert($color);

        self::assertInstanceOf(AnsiCode::class, $actual);
        self::assertSame('8;5;100', $actual->toString());
    }

    #[Test]
    public function canConvertAnsi24(): void
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
        $ansi4ColorDegrader = $this->getAnsi4DegraderMock();
        $ansi8ColorDegrader = $this->getAnsi8DegraderMock();

        $hexColorNormalizer
            ->expects(self::once())
            ->method('normalize')
            ->with($color)
            ->willReturn($color)
        ;

        $ansi4ColorDegrader
            ->expects(self::never())
            ->method('degrade')
        ;

        $ansi8ColorDegrader
            ->expects(self::never())
            ->method('degrade')
        ;

        $converter = $this->getTesteeInstance(
            styleMode: StylingMethodMode::ANSI24,
            hexColorNormalizer: $hexColorNormalizer,
            ansi4ColorDegrader: $ansi4ColorDegrader,
            ansi8ColorDegrader: $ansi8ColorDegrader,
        );

        $actual = $converter->convert($color);

        self::assertInstanceOf(AnsiCode::class, $actual);
        self::assertSame('8;2;1;12;123', $actual->toString());
    }
}
