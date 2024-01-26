<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Helper;


use AlecRabbit\Spinner\Helper\ISequenceHelper;
use AlecRabbit\Spinner\Helper\SequenceHelper;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class SequenceHelperTest extends TestCase
{
    public static function canGetDataProvider(): iterable
    {
        yield from [
            ['⠀', -19],
            ['⣿', 2956],
            ['⠀', 0b00000000],
            ['⣿', 0b11111111],
            ['⢸', 0b00001111],
            ['⡇', 0b11110000],
            ['⣀', 0b00010001],
            ['⣤', 0b00110011],
            ['⡀', 0b00010000],
            ['⢀', 0b00000001],
            ['⡄', 0b00110000],
            ['⣶', 0b01110111],
            ['⣦', 0b01110011],
            ['⣴', 0b00110111],
            ['⣄', 0b00110001],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $helper = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceHelper::class, $helper);
    }

    private function getTesteeInstance(): ISequenceHelper
    {
        return new SequenceHelper();
    }

    #[Test]
    #[DataProvider('canGetDataProvider')]
    public function canGet(string $expectedSymbol, mixed $input): void
    {
        $helper = $this->getTesteeInstance();

        self::assertEquals($expectedSymbol, $helper->get($input));
    }
}
