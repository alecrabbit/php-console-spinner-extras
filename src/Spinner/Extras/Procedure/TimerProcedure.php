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
use AlecRabbit\Spinner\Extras\CurrentTimeProvider;
use AlecRabbit\Spinner\Extras\EstimateDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\A\AProcedure;
use AlecRabbit\Spinner\Extras\Procedure\Contract\ITimerProcedure;
use DateTimeImmutable;

use function AlecRabbit\WCWidth\wcswidth;

/**
 * @psalm-suppress UnusedClass
 */
final  class TimerProcedure extends AProcedure implements ITimerProcedure, ICharPalette
{
    private const DEFAULT_FORMAT = '%s';

    public function __construct(
        private readonly DateTimeImmutable $target,
        private readonly ICurrentTimeProvider $currentTimeProvider = new CurrentTimeProvider(),
        private readonly IDateIntervalFormatter $intervalFormatter = new EstimateDateIntervalFormatter(),
        private readonly string $format = self::DEFAULT_FORMAT,
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct(options: $options);
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
