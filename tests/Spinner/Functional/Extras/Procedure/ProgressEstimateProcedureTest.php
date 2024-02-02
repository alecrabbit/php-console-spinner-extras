<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IProcedure;
use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\EstimateDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\ProgressEstimateProcedure;
use AlecRabbit\Spinner\Extras\Value\ProgressValue;
use AlecRabbit\Tests\TestCase\TestCase;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ProgressEstimateProcedureTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $procedure = $this->getTesteeInstance();

        self::assertInstanceOf(ProgressEstimateProcedure::class, $procedure);
    }

    private function getTesteeInstance(
        ?IProgressValue $progressValue = null,
        ?string $format = null,
        ICurrentTimeProvider $currentTimeProvider = null,
        IDateIntervalFormatter $intervalFormatter = new EstimateDateIntervalFormatter()
    ): IProcedure {
        return new ProgressEstimateProcedure(
            progressValue: $progressValue ?? new ProgressValue(),
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
        $progressValue = new ProgressValue();

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
            progressValue: $progressValue,
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
