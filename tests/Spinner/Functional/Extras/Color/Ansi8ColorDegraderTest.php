<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Ansi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi8ColorDegrader;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Ansi8ColorDegraderTest extends TestCase
{
    public static function canDegradeDataProvider(): iterable
    {
        yield from [
            // expected, [input]
            [16, [1, 2, 3]],
            [16, [0, 0, 0]],
            [23, [12, 34, 42]],
            [123, [124, 235, 234]],
            [213, [240, 120, 231]],
            [201, [240, 10, 231]],
            [228, [240, 231, 120]],
            [226, [240, 231, 5]],
            [231, [255, 255, 255]],
            [255, [240, 240, 240]],
            [120, [0x87, 0xff, 0x87]],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $degrader = $this->getTesteeInstance();

        self::assertInstanceOf(Ansi8ColorDegrader::class, $degrader);
    }

    private function getTesteeInstance(): IAnsi8ColorDegrader
    {
        return new Ansi8ColorDegrader();
    }

    #[Test]
    #[DataProvider('canDegradeDataProvider')]
    public function canDegrade(int $expected, array $input): void
    {
        $degrader = $this->getTesteeInstance();

        self::assertEquals(
            $expected,
            $degrader->degrade(...$input)
        );
    }
}
