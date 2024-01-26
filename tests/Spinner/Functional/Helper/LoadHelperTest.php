<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Helper;


use AlecRabbit\Spinner\Helper\ILoadHelper;
use AlecRabbit\Spinner\Helper\LoadHelper;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class LoadHelperTest extends TestCase
{
    public static function canGetDataProvider(): iterable
    {
        yield from [
            [
                [
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000000, 0],
                    [0b00000011, 0.5],
                    [0b00110001, 0.25],
                    [0b00011111, 1],
                    [0b11110011, 0.5],
                    [0b00110111, 0.75],
                    [0b01110000, 0.11],
                    [0b00000000, 0.0],
                    [0b00000001, 0.33],
                    [0b00010111, 0.73],
                    [0b01111111, 0.99],
                    [0b11110001, 0.23],
                    [0b00010011, 0.38],
                    [0b00111111, 1.38],
                    [0b11111111, 1.38],
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $helper = $this->getTesteeInstance();

        self::assertInstanceOf(LoadHelper::class, $helper);
    }

    private function getTesteeInstance(): ILoadHelper
    {
        return new LoadHelper();
    }

    #[Test]
    #[DataProvider('canGetDataProvider')]
    public function canGet(array $data): void
    {
        $helper = $this->getTesteeInstance();

        foreach ($data as $item) {
            [$expected, $input] = $item;

            $helper->add($input);

            self::assertEquals(
                str_pad(decbin($expected), 8, '0', STR_PAD_LEFT),
                str_pad(decbin($helper->get()), 8, '0', STR_PAD_LEFT),
            );
        }
        self::assertTrue(true);
    }
}
