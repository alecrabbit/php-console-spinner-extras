<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras;

use AlecRabbit\Spinner\Extras\Contract\ISecondsToDurationStringConverter;
use AlecRabbit\Spinner\Extras\SecondsToDurationStringConverter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SecondsToDurationStringConverterTest extends TestCase
{
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
}
