<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Palette\Style;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use AlecRabbit\Spinner\Extras\Palette\Style\CustomStylePalette;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class CustomStylePaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(CustomStylePalette::class, $palette);
    }

    private function getTesteeInstance(
        ?Traversable $frames = null,
        ?int $frameWidth = null,
        ?IPaletteOptions $options = null,
    ): IInfinitePalette {
        return new CustomStylePalette(
            frames: $frames ?? $this->getTraversableMock(),
            frameWidth: $frameWidth,
            options: $options ?? $this->getPaletteOptionsMock(),
        );
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
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

    #[Test]
    public function canGetEntriesOne(): void
    {
        $frames = new ArrayObject(['a', 'b', 'c']);
        $palette = $this->getTesteeInstance(
            frames: $frames,
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
        $palette = $this->getTesteeInstance(
            frames: $frames,
            frameWidth: 1,
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

        self::assertEquals(new StyleFrame('a', 1), $entries->current());

        for ($i = 0; $i < 10; $i++) {
            $entries->next();
            self::assertEquals(new StyleFrame('b', 1), $entries->current());
            $entries->next();
            self::assertEquals(new StyleFrame('c', 1), $entries->current());
            $entries->next();
        }
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }
}
