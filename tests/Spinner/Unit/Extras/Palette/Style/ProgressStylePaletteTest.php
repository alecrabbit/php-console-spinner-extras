<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Palette\Style;


use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\IInfinitePalette;
use AlecRabbit\Spinner\Extras\Palette\Style\ProcedureStylePalette;
use AlecRabbit\Tests\TestCase\TestCase;
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
}
