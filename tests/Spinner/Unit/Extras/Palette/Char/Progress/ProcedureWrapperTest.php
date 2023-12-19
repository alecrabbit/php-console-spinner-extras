<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Palette\Char\Progress;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Extras\Palette\Char\Progress\ProcedureWrapper;
use AlecRabbit\Spinner\Extras\Palette\Contract\ITraversableWrapper;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ProcedureWrapperTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(ProcedureWrapper::class, $palette);
    }

    private function getTesteeInstance(
        IProcedure $procedure = null,
    ): ITraversableWrapper
    {
        return new ProcedureWrapper(
            procedure: $procedure ?? $this->getProcedureMock(),
        );
    }

    private function getProcedureMock():MockObject&IProcedure
    {
        return $this->createMock(IProcedure::class);
    }
}
