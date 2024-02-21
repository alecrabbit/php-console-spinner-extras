<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\ProgressEstimateProcedure;
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

        $procedure = $this->getTesteeInstance(
            progressValue: $progressValue
        );

        self::assertInstanceOf(ProgressEstimateProcedure::class, $procedure);
    }

    private function getProgressValueMock(): MockObject&IProgressValue
    {
        return $this->createMock(IProgressValue::class);
    }

    private function getTesteeInstance(
        ?IProgressValue $progressValue = null,
        ?string $format = null,
    ): IProcedure {
        return new ProgressEstimateProcedure(
            progressValue: $progressValue ?? $this->getProgressValueMock(),
            format: $format ?? '-%s-',
        );
    }
}
