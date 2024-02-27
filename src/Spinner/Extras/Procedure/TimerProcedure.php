<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\ICurrentTimeProvider;
use AlecRabbit\Spinner\Extras\Contract\IDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\CurrentTimeProvider;
use AlecRabbit\Spinner\Extras\EstimateDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\A\AProcedure;
use AlecRabbit\Spinner\Extras\Procedure\Contract\ITimerProcedure;
use AlecRabbit\Spinner\Extras\Value\Contract\ITimerValue;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;
use DateTimeImmutable;

use function AlecRabbit\WCWidth\wcswidth;

/**
 * @psalm-suppress UnusedClass
 */
final  class TimerProcedure extends AProcedure implements ITimerProcedure, ICharPalette
{
    private const DEFAULT_FORMAT = '%s';
    private readonly DateTimeImmutable $target;

    public function __construct(
        IValueReference $reference,
        private readonly IDateIntervalFormatter $intervalFormatter = new EstimateDateIntervalFormatter(),
        private readonly ICurrentTimeProvider $currentTimeProvider = new CurrentTimeProvider(),
        private readonly string $format = self::DEFAULT_FORMAT,
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct(
            reference: $reference,
            options: $options,
        );

        $this->target = $this->reference->getWrapper()->unwrap();
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createFrame(
            $this->createFrameSequence()
        );
    }

    private function createFrame(string $sequence): IFrame
    {
        if ($sequence === '') {
            return new CharSequenceFrame('', 0);
        }
        return new CharSequenceFrame($sequence, $this->getWidth($sequence));
    }

    private function getWidth(string $value): int
    {
        return wcswidth($value); // TODO (2024-02-27 13:25) [Alec Rabbit]: [431c50df-f9be-4a7e-b79c-569fd74470a5]
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

    protected function assertReference(): void
    {
        if (!$this->reference->getWrapper() instanceof ITimerValue) {
            throw new InvalidArgument(
                sprintf(
                    'Reference value is expected to contain an instance of %s.',
                    ITimerValue::class
                )
            );
        }
    }
}
