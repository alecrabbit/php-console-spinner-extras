<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Contract\ISecondsToDateIntervalConverter;
use AlecRabbit\Spinner\Extras\CurrentTimeProvider;
use AlecRabbit\Spinner\Extras\ElapsedDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\EstimatedDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use AlecRabbit\Spinner\Extras\SecondsToDateIntervalConverter;
use DateTimeImmutable;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressEstimateProcedure extends AProgressValueProcedure
{
    private const FORMAT = '%3s';
    private float $stepValue;
    private float $startValue;
    private DateTimeImmutable $createdAt;

    public function __construct(
        IProgressValue $progressValue,
        string $format = self::FORMAT,
        private readonly ICurrentTimeProvider $currentTimeProvider = new CurrentTimeProvider(),
        private readonly IDateIntervalFormatter $estimateFormatter = new EstimatedDateIntervalFormatter(),
        private readonly IDateIntervalFormatter $elapsedFormatter = new ElapsedDateIntervalFormatter(),
        private readonly ISecondsToDateIntervalConverter $converter = new SecondsToDateIntervalConverter(),
    ) {
        $this->createdAt = $this->currentTimeProvider->now();

        parent::__construct(
            progressValue: $progressValue,
            format: $format
        );

        $this->stepValue = $this->calculateStepValue($progressValue);
        $this->startValue = $progressValue->getValue();
    }

    protected function createFrameSequence(): string
    {
        $stepsDone = $this->getStepsDone();

        if ($stepsDone > 0) {
            $estimate = $this->getEstimate($stepsDone);

            if ($this->progressValue->isFinished()) {
                $estimate = 0;
            }

            if ($estimate > 0) {
                return sprintf(
                    $this->format,
                    $this->formatEstimate($estimate),
                );
            }
        }

        return '';
    }

    protected function getStepsDone(): int
    {
        return (int)(($this->progressValue->getValue() - $this->startValue) / $this->stepValue);
    }

    protected function getEstimate(int $stepsDone): int|float
    {
        $elapsed = $this->elapsed();

        $timePerStep = $elapsed / $stepsDone;

        $timeNeededForAllSteps = $timePerStep * $this->progressValue->getSteps();

        return $timeNeededForAllSteps - $elapsed;
    }

    private function elapsed(): int
    {
        return $this->currentTimeProvider->now()->getTimestamp() - $this->createdAt->getTimestamp();
    }

    protected function formatEstimate(float|int $remainingTime): string
    {
        if ($remainingTime > 600) {
            return $this->estimateFormatter->format(
                $this->converter->convert((int)$remainingTime)
            );
        }

        return $this->elapsedFormatter->format(
            $this->converter->convert((int)$remainingTime)
        );
    }

    protected function calculateStepValue(IProgressValue $progressValue): float
    {
        return ($progressValue->getMax() - $progressValue->getMin()) / $progressValue->getSteps();
    }
}
