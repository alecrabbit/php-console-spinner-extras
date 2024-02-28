<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Contract\IProgressWrapper;
use AlecRabbit\Spinner\Extras\CurrentTimeProvider;
use AlecRabbit\Spinner\Extras\FineDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;
use DateTimeImmutable;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressElapsedProcedure extends AProgressValueProcedure implements ICharPalette
{
    private const FORMAT = '%3s';
    private DateTimeImmutable $createdAt;
    private IProgressWrapper $progress;
    private \DateInterval $elapsed;

    public function __construct(
        IValueReference $reference,
        string $format = self::FORMAT,
        private readonly ICurrentTimeProvider $currentTimeProvider = new CurrentTimeProvider(),
        private readonly IDateIntervalFormatter $intervalFormatter = new FineDateIntervalFormatter(),
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct($reference, $format, $options);
        $this->createdAt = $this->currentTimeProvider->now();

        if ($this->wrapper instanceof IProgressWrapper) {
            $this->progress = $this->wrapper;
        }

        $this->elapsed = $this->getDiff($this->createdAt);
    }

    private function getDiff(\DateTimeImmutable $now): \DateInterval
    {
        return $this->createdAt->diff($now);
    }

    public function getFrame(?float $dt = null): IFrame
    {
        if ($this->progress->isStarted() && !$this->progress->isFinished()) {
            $this->elapsed = $this->getDiff($this->currentTimeProvider->now());
        }

        $sequence = sprintf(
            $this->format,
            $this->intervalFormatter->format($this->elapsed),
        );

        return new CharSequenceFrame($sequence, $this->getWidth($sequence));
    }
}
