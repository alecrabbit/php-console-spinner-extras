<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras;

use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\ElapsedDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\ILabels;
use AlecRabbit\Spinner\Extras\Labels;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class ElapsedDateIntervalFormatterTest extends TestCase
{
    public static function canFormatDataProvider(): iterable
    {
        yield from [
            ['4m 2d 15h 22min 10sec', new \DateInterval('P4M2DT15H22M10S')],
            ['', new \DateInterval('PT0S')],
            ['7m 18d 13h 46min 40sec', new \DateInterval('P7M18DT13H46M40S')],
            ['2y 1m 27d 2h', new \DateInterval('P2Y1M27DT2H0M0S')],
            ['42sec', new \DateInterval('P0Y0M0DT0H0M42S')],
            ['46min 40sec', new \DateInterval('P0Y0M0DT0H46M40S')],
            ['48min 56sec', new \DateInterval('P0Y0M0DT0H48M56S')],
            ['1000sec', new \DateInterval('PT1000S')],
            ['3h', new \DateInterval('PT3H')],
            ['1min', new \DateInterval('PT1M')],
            ['1d', \DateInterval::createFromDateString('1 day')],
            ['1sec', \DateInterval::createFromDateString('1 sec')],
            ['1min 45sec', \DateInterval::createFromDateString('1 min + 45 sec')],
            ['1y 1d', \DateInterval::createFromDateString('1 year + 1 day')],
            ['4y 7m', \DateInterval::createFromDateString('4 year + 7 month')],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(ElapsedDateIntervalFormatter::class, $formatter);
    }

    private function getTesteeInstance(
        ?ILabels $labels = null,
    ): IDateIntervalFormatter {
        return new ElapsedDateIntervalFormatter(
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
