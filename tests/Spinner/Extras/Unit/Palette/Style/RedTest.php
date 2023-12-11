<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Extras\Unit\Palette\Style;


use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\Builder\PaletteTemplateBuilder;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\PaletteTemplate;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Palette\Style\Red;
use AlecRabbit\Tests\TestCase\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RedTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(Red::class, $palette);
    }

    private function getTesteeInstance(
        ?IPaletteOptions $options = null,
    ): IPalette {
        return
            new Red(
                options: $options ?? $this->getPaletteOptionsMock(),
            );
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function canGetTemplateWithMode(): void
    {
        $palette = $this->getTesteeInstance();

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::never())
            ->method('getStylingMode')
        ;

        $template = $this->createTemplate($mode, $palette);

        self::assertInstanceOf(PaletteTemplate::class, $template);
        self::assertInstanceOf(Generator::class, $template->getEntries());
        self::assertNull($template->getOptions()->getInterval());
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    #[Test]
    public function returnsOneFrameIteratorWithoutMode(): void
    {
        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::NONE)
        ;

        $template = $this->createTemplate($mode);

        $traversable = $template->getEntries();

        self::assertInstanceOf(Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new StyleFrame('%s', 0), $entries[0]);

        self::assertNull($template->getOptions()->getInterval());
    }

    #[Test]
    public function returnsOneFrameIteratorOnStylingModeNone(): void
    {
        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::NONE)
        ;

        $template = $this->createTemplate($mode);

        $traversable = $template->getEntries();

        self::assertInstanceOf(Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new StyleFrame('%s', 0), $entries[0]);

        self::assertNull($template->getOptions()->getInterval());
    }

    #[Test]
    public function returnsOneFrameIteratorOnStylingModeANSI4(): void
    {
        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI4)
        ;

        $template = $this->createTemplate($mode, $palette);

        $traversable = $template->getEntries();

        self::assertInstanceOf(Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new StyleFrame("\e[31m%s\e[39m", 0), $entries[0]);

        self::assertNull($template->getOptions()->getInterval());
    }

    #[Test]
    public function returnsOneFrameIteratorOnStylingModeANSI8(): void
    {
        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI8)
        ;

        $template = $this->createTemplate($mode, $palette);

        $traversable = $template->getEntries();

        self::assertInstanceOf(Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new StyleFrame("\e[31m%s\e[39m", 0), $entries[0]);

        self::assertNull($template->getOptions()->getInterval());
    }

    #[Test]
    public function returnsOneFrameIteratorOnStylingModeANSI24(): void
    {
        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI24)
        ;

        $template = $this->createTemplate($mode, $palette);

        $traversable = $template->getEntries();

        self::assertInstanceOf(Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new StyleFrame("\e[31m%s\e[39m", 0), $entries[0]);

        self::assertNull($template->getOptions()->getInterval());
    }

    private function createTemplate(IPaletteMode $mode, ?IPalette $palette = null): IPaletteTemplate
    {
        $palette ??= $this->getTesteeInstance();

        $templateBuilder = new PaletteTemplateBuilder();

        return $templateBuilder
            ->withEntries($palette->getEntries($mode))
            ->withOptions($palette->getOptions($mode))
            ->build()
        ;
    }
}
