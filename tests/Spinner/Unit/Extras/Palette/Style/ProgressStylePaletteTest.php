<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Palette\Style;


use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use AlecRabbit\Spinner\Extras\Palette\Contract\IInvokablePalette;
use AlecRabbit\Spinner\Extras\Palette\Style\ProgressStylePalette;
use AlecRabbit\Tests\TestCase\TestCase;
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
        ?IInvokablePalette $palette = null,
        IPaletteOptions $options = new PaletteOptions(),
    ): IInfinitePalette {
        return new ProgressStylePalette(
            palette: $palette ?? $this->getInvokablePaletteMock(),
            options: $options,
        );
    }

    private function getInvokablePaletteMock(): MockObject&IInvokablePalette
    {
        return $this->createMock(IInvokablePalette::class);
    }
}
