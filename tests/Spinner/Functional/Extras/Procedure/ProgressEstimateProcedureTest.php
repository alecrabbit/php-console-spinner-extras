<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\IProgressWrapper;
use AlecRabbit\Spinner\Extras\EstimateDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\ProgressEstimateProcedure;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;
use AlecRabbit\Spinner\Extras\Value\ProgressWrapper;
use AlecRabbit\Spinner\Extras\Value\ValueReference;
use AlecRabbit\Tests\TestCase\TestCase;
use DateTimeImmutable;
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
        ICurrentTimeProvider $currentTimeProvider = null,
        IDateIntervalFormatter $intervalFormatter = new EstimateDateIntervalFormatter()
    ): IProcedure {
        return new ProgressEstimateProcedure(
            reference: $reference ?? $this->getValueReferenceMock(),
            format: $format ?? '-%s-',
            currentTimeProvider: $currentTimeProvider ?? $this->getCurrentTimeProviderMock(),
            estimateFormatter: $intervalFormatter,
        );
    }

    private function getCurrentTimeProviderMock(): MockObject&ICurrentTimeProvider
    {
        return $this->createMock(ICurrentTimeProvider::class);
    }

    #[Test]
    public function canGetFrame(): void
    {
        $progressValue = new ProgressWrapper();

        $reference = new ValueReference($progressValue);

        $createdAt = new DateTimeImmutable('-900 seconds');

        $currentTimeProvider = $this->getCurrentTimeProviderMock();
        $currentTimeProvider
            ->expects(self::exactly(6))
            ->method('now')
            ->willReturnOnConsecutiveCalls(
                $createdAt,
                $createdAt->modify('+15 second'),
                $createdAt->modify('+115 second'),
                $createdAt->modify('+215 second'),
                $createdAt->modify('+285 second'),
                $createdAt->modify('+315 second'),
            )
        ;

        $procedure = $this->getTesteeInstance(
            reference: $reference,
            currentTimeProvider: $currentTimeProvider,
        );

        $frame = $procedure->getFrame();
        self::assertSame('', $frame->getSequence());
        self::assertSame(0, $frame->getWidth());

        $progressValue->advance(5);
        $frame = $procedure->getFrame();
        self::assertSame('-4min 45sec-', $frame->getSequence());
        self::assertSame(12, $frame->getWidth());

        $progressValue->advance(5);
        $frame = $procedure->getFrame();
        self::assertSame('-32min-', $frame->getSequence());
        self::assertSame(7, $frame->getWidth());

        $progressValue->advance(5);
        $frame = $procedure->getFrame();
        self::assertSame('-27min-', $frame->getSequence());
        self::assertSame(7, $frame->getWidth());
        $progressValue->advance(85);
        $frame = $procedure->getFrame();
        self::assertSame('', $frame->getSequence());
        self::assertSame(0, $frame->getWidth());
    }
}
