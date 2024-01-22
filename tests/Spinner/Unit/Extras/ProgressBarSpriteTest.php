<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\ProgressBarSprite;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ProgressBarSpriteTest extends TestCase
{
    public static function canBeCreatedWithSampleDataProvider(): iterable
    {
        // [$expected, $sample]
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgument::class,
                    self::MESSAGE => 'Sample cannot be empty.',
                ],
            ],
            '', // sample
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgument::class,
                    self::MESSAGE => 'Sample must be 3 or 5 characters long.',
                ],
            ],
            '█▓░░', // sample
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgument::class,
                    self::MESSAGE => 'Sample must be 3 or 5 characters long.',
                ],
            ],
            '█', // sample
        ];
        yield [
            [
                self::EXCEPTION => [
                    self::CLASS_ => InvalidArgument::class,
                    self::MESSAGE => 'Sample must be 3 or 5 characters long.',
                ],
            ],
            '█ ', // sample
        ];
        yield [
            [
                self::DONE => '█',
                self::CURSOR => '▓',
                self::EMPTY => '░',
                self::OPEN => '',
                self::CLOSE => '',
            ],
            '█▓░', // sample
        ];
        yield [
            [
                self::DONE => '■',
                self::CURSOR => '▨',
                self::EMPTY => '□',
                self::OPEN => '',
                self::CLOSE => '',
            ],
            '■▨□', // sample
        ];
        yield [
            [
                self::DONE => 'd',
                self::CURSOR => 'c',
                self::EMPTY => 'e',
                self::OPEN => 'o',
                self::CLOSE => 'f',
            ],
            'odcef', // sample
        ];
        yield [
            [
                self::DONE => 'd',
                self::CURSOR => 'c',
                self::EMPTY => 'e',
                self::OPEN => '',
                self::CLOSE => '',
            ],
            'dce', // sample
        ];
        yield [
            [
                self::DONE => '=',
                self::CURSOR => '>',
                self::EMPTY => '-',
                self::OPEN => '[',
                self::CLOSE => ']',
            ],
            '[=>-]', // sample
        ];
    }

    #[Test]
    public function canBeCreatedWithDefaults(): void
    {
        $instance = new ProgressBarSprite();
        self::assertSame('', $instance->getOpen());
        self::assertSame('', $instance->getClose());
        self::assertSame('█', $instance->getDone());
        self::assertSame('▓', $instance->getCursor());
        self::assertSame('░', $instance->getEmpty());
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $empty = 'e';
        $done = 'd';
        $cursor = 'c';
        $open = 'o';
        $close = 'f';

        $instance = new ProgressBarSprite(
            empty: $empty,
            done: $done,
            cursor: $cursor,
            open: $open,
            close: $close,
        );

        self::assertSame($empty, $instance->getEmpty());
        self::assertSame($done, $instance->getDone());
        self::assertSame($cursor, $instance->getCursor());
        self::assertSame($open, $instance->getOpen());
        self::assertSame($close, $instance->getClose());
    }

    #[Test]
    #[DataProvider('canBeCreatedWithSampleDataProvider')]
    public function canBeCreatedWithSample(array $expected, string $sample): void
    {
        $exception = $this->expectsException($expected);

        $instance = new ProgressBarSprite(sample: $sample);

        if ($exception) {
            self::fail('Exception should be thrown.');
        }
        self::assertSame($expected[self::DONE], $instance->getDone());
        self::assertSame($expected[self::CURSOR], $instance->getCursor());
        self::assertSame($expected[self::EMPTY], $instance->getEmpty());
        self::assertSame($expected[self::OPEN], $instance->getOpen());
        self::assertSame($expected[self::CLOSE], $instance->getClose());
    }
}
