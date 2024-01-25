<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras;

use AlecRabbit\Spinner\Extras\Contract\ISecondsToDurationStringConverter;
use AlecRabbit\Spinner\Extras\SecondsToDurationStringConverter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class SecondsToDurationStringConverterTest extends TestCase
{
    public static function canConvertProvider(): iterable
    {
        return [
            [1, 'P0Y0M0DT0H0M1S'],
            [24, 'P0Y0M0DT0H0M24S'],
            [60, 'P0Y0M0DT0H1M0S'],
            [3600, 'P0Y0M0DT1H0M0S'],
            [3601, 'P0Y0M0DT1H0M1S'],
            [86400, 'P0Y0M1DT0H0M0S'],
            [121245, 'P0Y0M1DT9H40M45S'],
            [86401, 'P0Y0M1DT0H0M1S'],
            [124353451, 'P3Y11M29DT6H37M31S'],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(SecondsToDurationStringConverter::class, $converter);
    }

    protected function getTesteeInstance(): ISecondsToDurationStringConverter
    {
        return new SecondsToDurationStringConverter();
    }

    #[Test]
    #[DataProvider('canConvertProvider')]
    public function canConvert(int $seconds, string $expected): void
    {
        $converter = $this->getTesteeInstance();

        self::assertSame($expected, $converter->convert($seconds));
    }
}
