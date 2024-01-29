<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Helper;


use AlecRabbit\Spinner\Helper\ILoadToSymbolHelper;
use AlecRabbit\Spinner\Helper\LoadToSymbolHelper;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class LoadToSymbolHelperTest extends TestCase
{
    public static function canGetDataProvider(): iterable
    {
        yield from [
            [['⠀', '⠀', '⠀',], [0.00, 0.00, 0.00,]],
            [['⠀', '⢸', '⣿',], [0.00, 1.00, 1.00,]],
            [['⠀', '⢀', '⡀',], [0.00, 0.25, 0.00,]],
            [['⠀', '⢀', '⣀',], [0.00, 0.25, 0.37,]],
            [['⠀', '⢀', '⣠',], [0.00, 0.25, 0.49,]],
            [['⢠', '⣄', '⣠',], [0.48, 0.25, 0.49,]],
            [['⢀', '⣠', '⣴', '⣾',], [0.25, 0.55, 0.80, 1.49,]],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $helper = $this->getTesteeInstance();

        self::assertInstanceOf(LoadToSymbolHelper::class, $helper);
    }

    private function getTesteeInstance(): ILoadToSymbolHelper
    {
        return new LoadToSymbolHelper();
    }


    // FIXME (2024-01-29 16:13) [Alec Rabbit]: fix and enable this test
//    #[Test]
//    #[DataProvider('canGetDataProvider')]
//    public function canGet(array $expected, array $input): void
//    {
//        $helper = $this->getTesteeInstance();
//
//        foreach ($input as $key => $item) {
//            self::assertSame($expected[$key] ?? null, $helper->get($item));
//        }
//    }
}
