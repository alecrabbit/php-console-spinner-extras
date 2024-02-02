<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras;

use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\ClockDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\ILabels;
use AlecRabbit\Spinner\Extras\Labels;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class ClockDateIntervalFormatterTest extends TestCase
{
    public static function canFormatDataProvider(): iterable
    {
        $before = new \DateTimeImmutable('-121245 seconds');
        $now = new \DateTimeImmutable();

        yield from [
            ['4m', new \DateInterval('P4M2DT15H22M10S')],
            ['1d', new \DateInterval('P0Y0M1DT9H40M45S')],
            ['1d', $before->diff($now)],
            ['00:00:00', new \DateInterval('PT0S')],
            ['7m', new \DateInterval('P7M18DT13H46M40S')],
            ['2y', new \DateInterval('P2Y1M27DT2H0M0S')],
            ['00:00:42', new \DateInterval('P0Y0M0DT0H0M42S')],
            ['00:46:40', new \DateInterval('P0Y0M0DT0H46M40S')],
            ['00:48:56', new \DateInterval('P0Y0M0DT0H48M56S')],
            ['00:00:1000'/* should it be fixed? */, new \DateInterval('PT1000S')],
            ['03:00:00', new \DateInterval('PT3H')],
            ['00:01:00', new \DateInterval('PT1M')],
            ['1d', \DateInterval::createFromDateString('1 day')],
            ['00:00:01', \DateInterval::createFromDateString('1 sec')],
            ['00:01:45', \DateInterval::createFromDateString('1 min + 45 sec')],
            ['1y', \DateInterval::createFromDateString('1 year + 1 day')],
            ['4y', \DateInterval::createFromDateString('4 year + 7 month')],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(ClockDateIntervalFormatter::class, $formatter);
    }

    private function getTesteeInstance(
        ?ILabels $labels = null,
    ): IDateIntervalFormatter {
        return new ClockDateIntervalFormatter(
            labels: $labels ?? new Labels(),
        );
    }

    #[Test]
    #[DataProvider('canFormatDataProvider')]
    public function canFormat(string $expected, \DateInterval $input): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertEquals($expected, $formatter->format($input));
    }
}
