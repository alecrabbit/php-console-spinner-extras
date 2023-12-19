<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Palette\Style;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use AlecRabbit\Spinner\Extras\Palette\Contract\ITraversableWrapper;
use AlecRabbit\Spinner\Extras\Palette\Style\ProgressStylePalette;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ProgressStylePaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(ProgressStylePalette::class, $palette);
    }

    private function getTesteeInstance(
        ?ITraversableWrapper $palette = null,
        IPaletteOptions $options = new PaletteOptions(),
    ): IInfinitePalette {
        return new ProgressStylePalette(
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
    public function canGetEntriesOne(): void
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

        $entries = $palette->getEntries(); // no mode passed

        self::assertIsIterable($entries);
        self::assertInstanceOf(Generator::class, $entries);

        self::assertEquals(new StyleFrame('%s', 0), $entries->current());

        for ($i = 0; $i < 10; $i++) {
            $entries->next();
            self::assertEquals(new StyleFrame('%s', 0), $entries->current());
        }
    }

    #[Test]
    public function canGetEntriesTwo(): void
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
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI8)
        ;

        $entries = $palette->getEntries($mode);

        self::assertIsIterable($entries);
        self::assertInstanceOf(Generator::class, $entries);

        self::assertEquals(new StyleFrame('a', 0), $entries->current());

        for ($i = 0; $i < 10; $i++) {
            $entries->next();
            self::assertEquals(new StyleFrame('b', 0), $entries->current());
            $entries->next();
            self::assertEquals(new StyleFrame('c', 0), $entries->current());
            $entries->next();
        }
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }
}
