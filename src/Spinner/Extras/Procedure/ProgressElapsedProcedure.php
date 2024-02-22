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
use AlecRabbit\Spinner\Extras\CurrentTimeProvider;
use AlecRabbit\Spinner\Extras\FineDateIntervalFormatter;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use DateTimeImmutable;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressElapsedProcedure extends AProgressValueProcedure implements ICharPalette
{
    private const FORMAT = '%3s';
    private DateTimeImmutable $createdAt;

    public function __construct(
        IProgressValue $progressValue,
        string $format = self::FORMAT,
        private readonly ICurrentTimeProvider $currentTimeProvider = new CurrentTimeProvider(),
        private readonly IDateIntervalFormatter $intervalFormatter = new FineDateIntervalFormatter(),
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct($progressValue, $format, $options);
        $this->createdAt = $this->currentTimeProvider->now();
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

    private function createFrameSequence(): string
    {
        $elapsed = $this->createdAt->diff($this->currentTimeProvider->now());

        return sprintf(
            $this->format,
            $this->intervalFormatter->format($elapsed),
        );
    }
}
