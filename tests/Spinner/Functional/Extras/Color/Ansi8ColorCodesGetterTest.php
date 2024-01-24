<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Ansi8ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Ansi8ColorCodesGetterTest extends TestCase
{
    public static function canGetCodesDataProvider(): iterable
    {
        yield from [
            // [expected], [input]
            [[8, 5, 213], [240, 120, 231]],
            [[8, 5, 201], [240, 10, 231]],
            [[8, 5, 228], [240, 231, 120]],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $getter = $this->getTesteeInstance();

        self::assertInstanceOf(Ansi8ColorCodesGetter::class, $getter);
    }

    private function getTesteeInstance(
        ?IAnsi8ColorDegrader $ansi8ColorDegrader = null
    ): IColorCodesGetter {
        return new Ansi8ColorCodesGetter(
            $ansi8ColorDegrader ?? new Ansi8ColorDegrader()
        );
    }
    #[Test]
    #[DataProvider('canGetCodesDataProvider')]
    public function canGetCodes(array $expected, array $input): void
    {
        $getter = $this->getTesteeInstance();

        self::assertEquals(
            $expected,
            $getter->getCodes(...$input)
        );
    }
}
