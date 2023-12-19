<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Palette\Char;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use AlecRabbit\Spinner\Extras\Palette\Char\ProgressCharPalette;
use AlecRabbit\Spinner\Extras\Palette\Contract\ITraversableWrapper;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ProgressCharPaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(ProgressCharPalette::class, $palette);
    }

    private function getTesteeInstance(
        ?ITraversableWrapper $palette = null,
        IPaletteOptions $options = new PaletteOptions(),
    ): IInfinitePalette {
        return new ProgressCharPalette(
            palette: $palette ?? $this->getInvokablePaletteMock(),
            options: $options,
        );
    }

    private function getInvokablePaletteMock(): MockObject&ITraversableWrapper
    {
        return $this->createMock(ITraversableWrapper::class);
    }

    #[Test]
    public function canGetOptionsIntervalOne(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertNull($palette->getOptions()->getInterval());
    }

    #[Test]
    public function canGetOptionsIntervalTwo(): void
    {
        $interval = 142;

        $options = $this->getPaletteOptionsMock();
        $options
            ->expects($this->once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $palette = $this->getTesteeInstance(
            options: $options,
        );

        self::assertSame($interval, $palette->getOptions()->getInterval());
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function canGetEntries(): void
    {
        $frames = new ArrayObject(['a', 'b', 'c']);
        $invokablePalette = $this->getInvokablePaletteMock();
        $invokablePalette
            ->expects(self::once())
            ->method('__invoke')
            ->willReturn($frames)
        ;

        $palette = $this->getTesteeInstance(
            palette: $invokablePalette,
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::never())
            ->method('getStylingMode')
        ;

        $entries = $palette->getEntries($mode);

        self::assertIsIterable($entries);
        self::assertInstanceOf(Generator::class, $entries);

        self::assertEquals(new CharFrame('a', 1), $entries->current());

        for ($i = 0; $i < 10; $i++) {
            $entries->next();
            self::assertEquals(new CharFrame('b', 1), $entries->current());
            $entries->next();
            self::assertEquals(new CharFrame('c', 1), $entries->current());
            $entries->next();
        }
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }
}
