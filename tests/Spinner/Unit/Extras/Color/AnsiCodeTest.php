<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\AnsiCode;
use AlecRabbit\Spinner\Extras\Contract\IAnsiCode;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class AnsiCodeTest extends TestCase
{
    public static function canToStringDataProvider(): iterable
    {
        yield from [
            [
                [
                    self::RESULT => '',
                ],
                [
                    self::ARGUMENTS => [],
                ],
            ],
            [
                [
                    self::RESULT => '0',
                ],
                [
                    self::ARGUMENTS => [0],
                ],
            ],
            [
                [
                    self::RESULT => '8;2;196;196;196',
                ],
                [
                    self::ARGUMENTS => [8, 2, 196, 196, 196,],
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(AnsiCode::class, $converter);
    }

    public function getTesteeInstance(
        ?array $codes = null,
    ): IAnsiCode {
        return new AnsiCode(
            ...$codes ?? [],
        );
    }

    #[Test]
    #[DataProvider('canToStringDataProvider')]
    public function canToString(array $expected, array $incoming): void
    {
        $expectedException = $this->expectsException($expected);

        $codes = $incoming[self::ARGUMENTS];
        $expectedResult = $expected[self::RESULT];

        $converter = $this->getTesteeInstance(
            codes: $codes,
        );

        $actual = $converter->toString();

        if ($expectedException) {
            self::failTest($expectedException);
        }

        self::assertSame($expectedResult, $actual);
    }
}
