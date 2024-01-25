<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Extras;

use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\EstimatedDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\ILabels;
use AlecRabbit\Spinner\Extras\Labels;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;


final class EstimatedDateIntervalFormatterTest extends TestCase
{
    public static function canFormatDataProvider(): iterable
    {
        yield from [
            ['4m', new \DateInterval('P4M2DT13H46M40S')],
            ['0', new \DateInterval('PT0S')],
            ['8m', new \DateInterval('P7M18DT13H46M40S')],
            ['2y', new \DateInterval('P2Y1M11DT13H46M40S')],
            ['42sec', new \DateInterval('P0Y0M0DT0H0M42S')],
            ['47min', new \DateInterval('P0Y0M0DT0H46M40S')],
            ['12d', new \DateInterval('P11DT13H46M40S')],
            ['3y', new \DateInterval('P2Y7M11DT13H46M40S')],
            ['1000sec', new \DateInterval('PT1000S')],
            ['3h', new \DateInterval('PT3H')],
            ['1min', new \DateInterval('PT1M')],
            ['1d', \DateInterval::createFromDateString('1 day')],
            ['1sec', \DateInterval::createFromDateString('1 sec')],
            ['2min', \DateInterval::createFromDateString('1 min + 45 sec')],
            ['1y', \DateInterval::createFromDateString('1 year + 1 day')],
            ['5y', \DateInterval::createFromDateString('4 year + 7 month')],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $formatter = $this->getTesteeInstance();

        self::assertInstanceOf(EstimatedDateIntervalFormatter::class, $formatter);
    }

    private function getTesteeInstance(
        ?ILabels $labels = null,
    ): IDateIntervalFormatter {
        return new EstimatedDateIntervalFormatter(
            labels: $labels ?? new Labels(),
        );
    }

    #[Test]
    #[DataProvider('canFormatDataProvider')]
    public function canFormat(string $expected, \DateInterval $input): void
    {
        $formatter = $this->getTesteeInstance();
//        dump($input);
//        dump($input->format('%y %m %d %h %i %s'));
        self::assertEquals($expected, $formatter->format($input));
    }
}
