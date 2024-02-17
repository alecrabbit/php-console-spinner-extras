<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras;

use AlecRabbit\Spinner\Extras\Contract\ISecondsToDateIntervalConverter;
use AlecRabbit\Spinner\Extras\SecondsToDateIntervalConverter;
use AlecRabbit\Tests\TestCase\TestCase;
use DateInterval;
use PHPUnit\Framework\Attributes\Test;

final class SecondsToDateIntervalConverterTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(SecondsToDateIntervalConverter::class, $converter);
    }

    protected function getTesteeInstance(): ISecondsToDateIntervalConverter
    {
        return new SecondsToDateIntervalConverter();
    }

    #[Test]
    public function canConvert(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertEquals(
            new DateInterval('PT42S'),
            $converter->convert(42)
        );
    }
}
