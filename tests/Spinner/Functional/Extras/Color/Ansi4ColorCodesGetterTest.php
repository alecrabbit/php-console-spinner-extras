<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Ansi4ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Ansi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi4ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class Ansi4ColorCodesGetterTest extends TestCase
{
    public static function canGetCodesDataProvider(): iterable
    {
        yield from [
            // [expected], [input]
            [[0], [1, 2, 3]],
            [[0], [0, 0, 0]],
            [[7], [255, 255, 255]],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $getter = $this->getTesteeInstance();

        self::assertInstanceOf(Ansi4ColorCodesGetter::class, $getter);
    }

    private function getTesteeInstance(
        ?IAnsi4ColorDegrader $ansi4ColorDegrader = null
    ): IColorCodesGetter {
        return new Ansi4ColorCodesGetter(
            $ansi4ColorDegrader ?? new Ansi4ColorDegrader()
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
