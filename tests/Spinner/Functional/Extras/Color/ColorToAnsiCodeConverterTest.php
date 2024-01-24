<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Functional\Extras\Color;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Color\Ansi24ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi4ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Ansi8ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\ColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Contract\IHexColorNormalizer;
use AlecRabbit\Spinner\Extras\Color\HexColorNormalizer;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Tests\Spinner\Unit\Extras\Color\SimpleHexColorToAnsiCodeConverterTest;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ColorToAnsiCodeConverterTest extends TestCase
{
    protected static function coreTestCanConvertDataProvider(): iterable
    {
        $src = SimpleHexColorToAnsiCodeConverterTest::class;
        yield from $src::canConvertDataProvider();
    }

    public static function canConvertDataProvider(): iterable
    {
        foreach (self::simpleCanConvertDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0],
                ],
                [
                    self::ARGUMENTS => [
                        self::COLOR => $item[1],
                        self::STYLE_MODE => $item[2],
                    ],
                ],
            ];
        }
    }

    protected static function simpleCanConvertDataFeeder(): iterable
    {
        $ansi4 = StylingMethodMode::ANSI4;
        $ansi8 = StylingMethodMode::ANSI8;
        $ansi24 = StylingMethodMode::ANSI24;

        yield from [
            // result, color, styleMode
            ['0', '#761176', $ansi4], // color degrading
            ['4', '#00008f', $ansi4], // color degrading
            ['5', '#861185', $ansi4], // color degrading
            ['5', '#d75f87', $ansi4], // color degrading
            ['5', '#d134f2', $ansi4], // color degrading

            ['8;5;238', '#444', $ansi8],
            ['8;5;255', '#eee', $ansi8],
            ['8;5;231', '#fff', $ansi8],
            ['8;5;59', '#434544', $ansi8],
            ['8;5;238', '#454545', $ansi8],
            ['8;5;231', '#fafafa', $ansi8],
            ['8;5;16', '#070707', $ansi8],
            ['8;2;198;198;198', '#c6c6c6', $ansi24],
            ['8;2;255;135;135', '#ff8787', $ansi24],
        ];
    }

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
            hexColorNormalizer: $hexColorNormalizer ?? new HexColorNormalizer(),
            colorCodesGetter: $colorCodesGetter ?? $this->getColorCodesGetter(),
        );
    }

    private function getColorCodesGetter(StylingMethodMode $styleMode = null): IColorCodesGetter
    {
        return match ($styleMode) {
            StylingMethodMode::ANSI24 => new Ansi24ColorCodesGetter(),
            StylingMethodMode::ANSI8 => new Ansi8ColorCodesGetter(new Ansi8ColorDegrader()),
            default => new Ansi4ColorCodesGetter(new Ansi4ColorDegrader()),
        };
    }

    #[Test]
    #[DataProvider('canConvertDataProvider')]
    public function canConvert(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $args = $incoming[self::ARGUMENTS];
        $expectedResult = $expected[self::RESULT];

        $color = $args[self::COLOR];
        $styleMode = $args[self::STYLE_MODE];

        $converter = $this->getTesteeInstance(
            colorCodesGetter: $this->getColorCodesGetter($styleMode),
        );

        $actual = $converter->convert($color)->toString();

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expectedResult, $actual);
    }
}
