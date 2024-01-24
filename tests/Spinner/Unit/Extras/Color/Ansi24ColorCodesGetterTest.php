<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Ansi24ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Ansi24ColorCodesGetterTest extends TestCase
{
    public static function canGetCodesDataProvider(): iterable
    {
        yield from [
            // [expected], [input]
            [[8, 2, 1, 2, 3], [1, 2, 3]],
            [[8, 2, 0, 0, 0], [0, 0, 0]],
            [[8, 2, 255, 255, 255], [255, 255, 255]],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $getter = $this->getTesteeInstance();

        self::assertInstanceOf(Ansi24ColorCodesGetter::class, $getter);
    }

    private function getTesteeInstance(): IColorCodesGetter
    {
        return new Ansi24ColorCodesGetter();
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
