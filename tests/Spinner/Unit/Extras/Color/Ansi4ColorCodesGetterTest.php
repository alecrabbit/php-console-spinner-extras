<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Ansi4ColorCodesGetter;
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
            [[1], [1, 2, 3]],
            [[1], [0, 0, 0]],
            [[1], [255, 255, 255]],
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
            $ansi4ColorDegrader ?? $this->getColorDegraderMock()
        );
    }

    private function getColorDegraderMock(): MockObject&IAnsi4ColorDegrader
    {
        return $this->createMock(IAnsi4ColorDegrader::class);
    }

    #[Test]
    #[DataProvider('canGetCodesDataProvider')]
    public function canGetCodes(array $expected, array $input): void
    {
        $degradedColor = $expected[0];

        $degrader = $this->getColorDegraderMock();
        $degrader
            ->expects(self::once())
            ->method('degrade')
            ->with(...$input)
            ->willReturn($degradedColor)
        ;

        $getter = $this->getTesteeInstance($degrader);

        self::assertEquals(
            $expected,
            $getter->getCodes(...$input)
        );
    }
}
