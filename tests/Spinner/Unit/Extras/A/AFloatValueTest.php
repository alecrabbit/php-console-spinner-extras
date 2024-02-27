<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\A;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Value\A\AFloatWrapper;
use AlecRabbit\Spinner\Extras\Value\Contract\IFloatWrapper;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class AFloatValueTest extends TestCase
{
    public static function createDataProvider(): iterable
    {
        // [$expected, $incoming]
        yield [
            [
                self::VALUE => $startValue = 0.0,
                self::MIN => $min = 0.0,
                self::MAX => $max = 1.0,
            ],
            [
                self::ARGUMENTS => [
                    self::START_VALUE => $startValue,
                    self::MIN => $min,
                    self::MAX => $max,
                ],
            ],
        ];
        yield [
            [
                self::VALUE => $max,
                self::MIN => $min,
                self::MAX => $max,
            ],
            [
                self::ARGUMENTS => [
                    self::START_VALUE => 4,
                    self::MIN => $min,
                    self::MAX => $max,
                ],
            ],
        ];
        yield [
            [
                self::VALUE => $min,
                self::MIN => $min,
                self::MAX => $max,
            ],
            [
                self::ARGUMENTS => [
                    self::START_VALUE => -1,
                    self::MIN => $min,
                    self::MAX => $max,
                ],
            ],
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgument::class,
                    self::MESSAGE => sprintf(
                        'Max value should be greater than min value. Min: "%s", Max: "%s".',
                        1,
                        0
                    ),
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::START_VALUE => 0.0,
                    self::MIN => 1.0,
                    self::MAX => 0.0,
                ],
            ],
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgument::class,
                    self::MESSAGE => 'Min and Max values cannot be equal.',
                ],
            ],
            [
                self::ARGUMENTS => [
                    self::START_VALUE => 0.0,
                    self::MIN => 1.0,
                    self::MAX => 1.0,
                ],
            ],
        ];
    }

    #[Test]
    #[DataProvider('createDataProvider')]
    public function create(array $expected, array $incoming): void
    {
        $this->expectsException($expected);

        $floatValue = self::getTesteeInstance($incoming[self::ARGUMENTS] ?? []);

        self::assertSame($expected[self::VALUE], $floatValue->unwrap());
        self::assertSame($expected[self::MIN], $floatValue->getMin());
        self::assertSame($expected[self::MAX], $floatValue->getMax());
    }

    public static function getTesteeInstance(array $args = []): IFloatWrapper
    {
        return new class(...$args) extends AFloatWrapper {
        };
    }
}
