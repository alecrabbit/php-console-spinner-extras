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
//            ['⢸', 0b00001111],
//            ['⡇', 0b11110000],
//            ['⣀', 0b10001000],
//            ['⡀', 0b10000000],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $helper = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceHelper::class, $helper);
    }

    private function getTesteeInstance():ISequenceHelper
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
