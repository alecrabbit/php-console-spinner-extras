<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Palette\Style;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use AlecRabbit\Spinner\Extras\Palette\Style\ProcedureStylePalette;
use AlecRabbit\Tests\TestCase\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ProgressStylePaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(ProcedureStylePalette::class, $palette);
    }

    private function getTesteeInstance(
        ?IProcedure $procedure = null,
        IPaletteOptions $options = new PaletteOptions(),
    ): IInfinitePalette {
        return new ProcedureStylePalette(
            procedure: $procedure ?? $this->getProcedureMock(),
            options: $options,
        );
    }

    private function getProcedureMock(): MockObject&IProcedure
    {
        return $this->createMock(IProcedure::class);
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
        $palette = $this->getTesteeInstance();

        $entries = $palette->getEntries(); // no mode passed

        self::assertIsIterable($entries);
        self::assertInstanceOf(Generator::class, $entries);
    }

    #[Test]
    public function canGetEntriesTwo(): void
    {
        $procedure = $this->getProcedureMock();
        $procedure
            ->method('getFrame')
            ->willReturn(new StyleFrame('-', 1))
        ;

        $palette = $this->getTesteeInstance(
            procedure: $procedure,
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

        for ($i = 0; $i < 3; $i++) {
            $frame = $entries->current();
            self::assertInstanceOf(StyleFrame::class, $frame);
            self::assertEquals(new StyleFrame('-', 1), $frame);
            $entries->next();
        }
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }
}
