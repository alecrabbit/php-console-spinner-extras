<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Contract\ISecondsToDateIntervalConverter;
use AlecRabbit\Spinner\Extras\CurrentTimeProvider;
use AlecRabbit\Spinner\Extras\EstimateDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\FineDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use AlecRabbit\Spinner\Extras\SecondsToDateIntervalConverter;
use DateTimeImmutable;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressEstimateProcedure extends AProgressValueProcedure implements ICharPalette
{
    private const FORMAT = '%3s';
    private float $stepValue;
    private float $startValue;
    private DateTimeImmutable $createdAt;

    public function __construct(
        IProgressValue $progressValue,
        string $format = self::FORMAT,
        private readonly ICurrentTimeProvider $currentTimeProvider = new CurrentTimeProvider(),
        private readonly IDateIntervalFormatter $estimateFormatter = new EstimateDateIntervalFormatter(),
        private readonly IDateIntervalFormatter $elapsedFormatter = new FineDateIntervalFormatter(),
        private readonly ISecondsToDateIntervalConverter $converter = new SecondsToDateIntervalConverter(),
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct($progressValue, $format, $options);

        $this->createdAt = $this->currentTimeProvider->now();
        $this->stepValue = $this->calculateStepValue($progressValue);
        $this->startValue = $progressValue->getValue();
    }

    private function calculateStepValue(IProgressValue $progressValue): float
    {
        return ($progressValue->getMax() - $progressValue->getMin()) / $progressValue->getSteps();
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createSequenceFrame(
            $this->createFrameSequence()
        );
    }

    private function createSequenceFrame(string $sequence): ISequenceFrame
    {
        if ($sequence === '') {
            return new CharSequenceFrame('', 0);
        }
        return new CharSequenceFrame($sequence, $this->getWidth($sequence));
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

    private function getStepsDone(): int
    {
        return (int)(($this->progressValue->getValue() - $this->startValue) / $this->stepValue);
    }

    private function getEstimate(int $stepsDone): int|float
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

    private function formatEstimate(float|int $estimate): string
    {
        $interval = $this->converter->convert((int)$estimate);

        if ($estimate < 300 && $this->elapsed() > 30) {
            return $this->elapsedFormatter->format($interval);
        }

        return $this->estimateFormatter->format($interval);
    }
}
