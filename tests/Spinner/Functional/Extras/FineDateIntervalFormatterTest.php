<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras;

use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\ILabels;
use AlecRabbit\Spinner\Extras\FineDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Labels;
use AlecRabbit\Tests\TestCase\TestCase;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class FineDateIntervalFormatterTest extends TestCase
{
    public static function canFormatDataProvider(): iterable
    {
        $before = new DateTimeImmutable('-121245 seconds');
        $now = new DateTimeImmutable();

        yield from [
            ['4m 2d 15h 22min 10sec', new DateInterval('P4M2DT15H22M10S')],
            ['1d 9h 40min 45sec', new DateInterval('P0Y0M1DT9H40M45S')],
            ['1d 9h 40min 45sec', $before->diff($now)],
            ['', new DateInterval('PT0S')],
            ['7m 18d 13h 46min 40sec', new DateInterval('P7M18DT13H46M40S')],
            ['2y 1m 27d 2h', new DateInterval('P2Y1M27DT2H0M0S')],
            ['42sec', new DateInterval('P0Y0M0DT0H0M42S')],
            ['46min 40sec', new DateInterval('P0Y0M0DT0H46M40S')],
            ['48min 56sec', new DateInterval('P0Y0M0DT0H48M56S')],
            ['1000sec', new DateInterval('PT1000S')],
            ['3h', new DateInterval('PT3H')],
            ['1min', new DateInterval('PT1M')],
            ['1d', DateInterval::createFromDateString('1 day')],
            ['1sec', DateInterval::createFromDateString('1 sec')],
            ['1min 45sec', DateInterval::createFromDateString('1 min + 45 sec')],
            ['1y 1d', DateInterval::createFromDateString('1 year + 1 day')],
            ['4y 7m', DateInterval::createFromDateString('4 year + 7 month')],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(FineDateIntervalFormatter::class, $formatter);
    }

    private function getTesteeInstance(
        ?ILabels $labels = null,
    ): IDateIntervalFormatter {
        return new FineDateIntervalFormatter(
            labels: $labels ?? new Labels(),
        );
    }

    #[Test]
    #[DataProvider('canFormatDataProvider')]
    public function canFormat(string $expected, DateInterval $input): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertEquals($expected, $formatter->format($input));
    }
}
