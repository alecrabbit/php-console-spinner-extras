<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Extras\Contract\IProgressWrapper;
use AlecRabbit\Spinner\Extras\Procedure\ProgressEstimateProcedure;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ProgressEstimateProcedureTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $progressValue = $this->getProgressValueMock();

        $progressValue
            ->expects(self::once())
            ->method('getSteps')
            ->willReturn(1)
        ;

        $reference = $this->getValueReferenceMock();
        $reference
            ->method('getWrapper')
            ->willReturn($progressValue)
        ;

        $procedure = $this->getTesteeInstance(
            reference: $reference
        );

        self::assertInstanceOf(ProgressEstimateProcedure::class, $procedure);
    }

    private function getProgressValueMock(): MockObject&IProgressWrapper
    {
        return $this->createMock(IProgressWrapper::class);
    }

    private function getValueReferenceMock(): MockObject&IValueReference
    {
        return $this->createMock(IValueReference::class);
    }

    private function getTesteeInstance(
        ?IValueReference $reference = null,
        ?string $format = null,
    ): IProcedure {
        return new ProgressEstimateProcedure(
            reference: $reference ?? $this->getValueReferenceMock(),
            format: $format ?? '-%s-',
        );
    }
}
