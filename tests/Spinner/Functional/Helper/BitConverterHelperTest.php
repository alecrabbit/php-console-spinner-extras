<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Helper;


use AlecRabbit\Spinner\Helper\BitConverterHelper;
use AlecRabbit\Spinner\Helper\IBitConverterHelper;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class BitConverterHelperTest extends TestCase
{
    public static function canGetDataProvider(): iterable
    {
        yield from [
            [0b00000000, 0b00000000, ],
            [0b10000000, 0b00000001, ],
            [0b01000000, 0b00000010, ],
            [0b00100000, 0b00000100, ],
            [0b00001000, 0b00001000, ],
            [0b00000100, 0b00010000, ],
            [0b00000010, 0b00100000, ],
            [0b00010000, 0b01000000, ],
            [0b00000001, 0b10000000, ],
            [0b00000101, 0b10010000, ],
            [0b00010101, 0b11010000, ],
            [0b00010111, 0b11110000, ],
            [0b00011111, 0b11111000, ],
            [0b11111111, 0b11111111, ],
            [0b11111101, 0b11011111, ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $helper = $this->getTesteeInstance();

        self::assertInstanceOf(BitConverterHelper::class, $helper);
    }

    private function getTesteeInstance(): IBitConverterHelper
    {
        return new BitConverterHelper();
    }

    #[Test]
    #[DataProvider('canGetDataProvider')]
    public function canGet(int $input, int $expected): void
    {
        $helper = $this->getTesteeInstance();

        self::assertEquals(
            str_pad(decbin($expected), 8, '0', STR_PAD_LEFT),
            str_pad(decbin($helper->convert($input)), 8, '0', STR_PAD_LEFT),
        );
    }
}
