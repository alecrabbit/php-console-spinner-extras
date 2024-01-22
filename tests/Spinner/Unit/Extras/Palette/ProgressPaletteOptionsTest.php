<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Extras\Palette\PaletteOptions;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ProgressPaletteOptionsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(PaletteOptions::class, $palette);
    }

    private function getTesteeInstance(
        ?int $interval = null,
        ?bool $reversed = null,
    ): IPaletteOptions {
        return
            new PaletteOptions(
                interval: $interval,
                reversed: $reversed ?? false,
            );
    }

    #[Test]
    public function canGetIsReversedWithTrue(): void
    {
        $palette = $this->getTesteeInstance(
            reversed: true,
        );

        self::assertTrue($palette->isReversed());
    }

    #[Test]
    public function canGetIsReversedWithFalse(): void
    {
        $palette = $this->getTesteeInstance(
            reversed: false,
        );

        self::assertFalse($palette->isReversed());
    }

    #[Test]
    public function canGetIntervalWithNull(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertNull($palette->getInterval());
    }

    #[Test]
    public function canGetDefaultInterval(): void
    {
        $palette = $this->getTesteeInstanceWithDefaults();

        self::assertSame(200, $palette->getInterval());
    }

    private function getTesteeInstanceWithDefaults(): IPaletteOptions
    {
        return
            new PaletteOptions();
    }

    #[Test]
    public function canGetIntervalWithNumber(): void
    {
        $interval = 100;
        $palette = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertSame($interval, $palette->getInterval());
    }
}
