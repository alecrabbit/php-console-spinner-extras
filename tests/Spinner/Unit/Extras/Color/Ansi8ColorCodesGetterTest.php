<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Ansi8ColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Contract\IAnsi8ColorDegrader;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class Ansi8ColorCodesGetterTest extends TestCase
{
    public static function canGetCodesDataProvider(): iterable
    {
        yield from [
            // [expected], [input]
            [[8, 5, 1], [1, 2, 3]],
            [[8, 5, 1], [0, 0, 0]],
            [[8, 5, 1], [255, 255, 255]],
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
            $ansi8ColorDegrader ?? $this->getColorDegraderMock()
        );
    }

    private function getColorDegraderMock(): MockObject&IAnsi8ColorDegrader
    {
        return $this->createMock(IAnsi8ColorDegrader::class);
    }

    #[Test]
    #[DataProvider('canGetCodesDataProvider')]
    public function canGetCodes(array $expected, array $input): void
    {
        $degradedColor = $expected[2];

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
