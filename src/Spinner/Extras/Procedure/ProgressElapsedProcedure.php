<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\CurrentTimeProvider;
use AlecRabbit\Spinner\Extras\DateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use DateInterval;
use DateTimeImmutable;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressElapsedProcedure extends AProgressValueProcedure
{
    private const FORMAT = '%3s';
    private DateTimeImmutable $createdAt;
    private int $elapsed = 0;

    public function __construct(
        IProgressValue $progressValue,
        string $format = self::FORMAT,
        private readonly ICurrentTimeProvider $currentTimeProvider = new CurrentTimeProvider(),
        private readonly IDateIntervalFormatter $intervalFormatter = new DateIntervalFormatter(),
    ) {
        $this->createdAt = $this->currentTimeProvider->now();

        parent::__construct(
            progressValue: $progressValue,
            format: $format
        );
    }

    protected function createFrameSequence(): string
    {
        $elapsed = $this->secondsPassed($this->createdAt);

        if ($elapsed > 0) {
            if (!$this->progressValue->isFinished()) {
                $this->elapsed = $elapsed;
            }
            return sprintf(
                $this->format,
                $this->intervalFormatter->format(
                    new DateInterval(
                        sprintf('PT%dS', $this->elapsed)
                    )
                ),
            );
        }

        return '';
    }

    private function secondsPassed(DateTimeImmutable $createdAt): int
    {
        return $this->currentTimeProvider->now()->getTimestamp() - $createdAt->getTimestamp();
    }
}
