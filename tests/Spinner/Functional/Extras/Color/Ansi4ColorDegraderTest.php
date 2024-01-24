<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Ansi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4ColorDegrader;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Ansi4ColorDegraderTest extends TestCase
{
    public static function canDegradeDataProvider(): iterable
    {
        yield from [
            // expected, [input]
            [0, [1, 2, 3]],
            [0, [0, 0, 0]],
            [0, [12, 34, 42]],
            [6, [124, 235, 234]],
            [5, [240, 120, 231]],
            [6, [20, 230, 231]],
            [5, [240, 10, 231]],
            [7, [0x81, 0x81, 0x81]],
            [3, [240, 231, 120]],
            [3, [240, 231, 5]],
            [7, [240, 240, 240]],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $degrader = $this->getTesteeInstance();

        self::assertInstanceOf(Ansi4ColorDegrader::class, $degrader);
    }

    private function getTesteeInstance(): IAnsi4ColorDegrader
    {
        return new Ansi4ColorDegrader();
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
