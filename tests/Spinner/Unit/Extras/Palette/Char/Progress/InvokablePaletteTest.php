<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Palette\Char\Progress;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Extras\Palette\Char\Progress\InvokablePalette;
use AlecRabbit\Spinner\Extras\Palette\Contract\IInvokablePalette;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class InvokablePaletteTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(InvokablePalette::class, $palette);
    }

    private function getTesteeInstance(
        IProcedure $procedure = null,
    ): IInvokablePalette
    {
        return new InvokablePalette(
            procedure: $procedure ?? $this->getProcedureMock(),
        );
    }

    private function getProcedureMock():MockObject&IProcedure
    {
        return $this->createMock(IProcedure::class);
    }
}
