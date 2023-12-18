<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\CurrentTimeProvider;
use AlecRabbit\Spinner\Extras\DateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressETCProcedure extends AProgressValueProcedure
{
    private const FORMAT = '%3s';
    private float $stepValue;
    private float $startValue;
    private \DateTimeImmutable $createdAt;

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

        $this->stepValue = ($progressValue->getMax() - $progressValue->getMin()) / $progressValue->getSteps();
        $this->startValue = $progressValue->getValue();
    }

    protected function createFrameSequence(): string
    {
        $currentValue = $this->progressValue->getValue();

        $stepsPerformed = (int)(($currentValue - $this->startValue) / $this->stepValue);

        if ($stepsPerformed > 0) {
            $timePassed = $this->secondsPassed($this->createdAt);

            $timePerStep = $timePassed / $stepsPerformed;

            $timeNeededForAllSteps = $timePerStep * $this->progressValue->getSteps();

            $remainingTime = $timeNeededForAllSteps - $timePassed;

            if ($remainingTime > 0) {
                return sprintf(
                    $this->format,
                    $this->intervalFormatter->format(
                        new \DateInterval(
                            sprintf('PT%dS', (int)$remainingTime)
                        )
                    ),
                );
            }
        }

        return sprintf(
            $this->format,
            '',
        );
    }

    private function secondsPassed(\DateTimeImmutable $createdAt): int
    {
        return $this->currentTimeProvider->now()->getTimestamp() - $createdAt->getTimestamp();
    }
}
