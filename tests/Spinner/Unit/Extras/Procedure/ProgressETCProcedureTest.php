<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\ProgressETCProcedure;
use AlecRabbit\Spinner\Extras\ProgressValue;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ProgressETCProcedureTest extends TestCase
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

        self::assertInstanceOf(ProgressETCProcedure::class, $procedure);
    }

    private function getProgressValueMock(): MockObject&IProgressValue
    {
        return $this->createMock(IProgressValue::class);
    }

    private function getTesteeInstance(
        ?IProgressValue $progressValue = null,
        ?string $format = null,
    ): IProcedure {
        return new ProgressETCProcedure(
            progressValue: $progressValue ?? $this->getProgressValueMock(),
            format: $format ?? '-%s-',
        );
    }
}
