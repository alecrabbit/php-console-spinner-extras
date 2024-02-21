<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\CurrentTimeProvider;
use AlecRabbit\Spinner\Extras\EstimateDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\Contract\ITimerProcedure;
use DateTimeImmutable;

use function AlecRabbit\WCWidth\wcswidth;

/**
 * @psalm-suppress UnusedClass
 */
final readonly class TimerProcedure implements ITimerProcedure
{
    private const DEFAULT_FORMAT = '%s';

    public function __construct(
        private DateTimeImmutable $target,
        private ICurrentTimeProvider $currentTimeProvider = new CurrentTimeProvider(),
        private IDateIntervalFormatter $intervalFormatter = new EstimateDateIntervalFormatter(),
        private string $format = self::DEFAULT_FORMAT,
    ) {
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createFrame(
            $this->createFrameSequence()
        );
    }

    protected function createFrame(string $sequence): IFrame
    {
        if ($sequence === '') {
            return new CharSequenceFrame('', 0);
        }
        return new CharSequenceFrame($sequence, $this->getWidth($sequence));
    }

    protected function getWidth(string $value): int
    {
        return wcswidth($value);
    }

    private function createFrameSequence(): string
    {
        $interval = $this->target->diff(
            $this->currentTimeProvider->now()
        );

        if ($interval->invert === 0) {
            return '';
        }

        return sprintf(
            $this->format,
            $this->intervalFormatter->format($interval),
        );
    }
}
