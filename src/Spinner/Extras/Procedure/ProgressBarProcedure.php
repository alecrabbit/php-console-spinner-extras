<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Extras\Contract\IProgressBarSprite;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use AlecRabbit\Spinner\Extras\ProgressBarSprite;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressBarProcedure extends AProgressValueProcedure
{
    private const UNITS = 5;
    private readonly float $cursorThreshold;
    private readonly int $units;

    public function __construct(
        IProgressValue $progressValue,
        int $units = self::UNITS,
        private readonly IProgressBarSprite $sprite = new ProgressBarSprite(),
        private readonly bool $withCursor = true,
    ) {
        parent::__construct($progressValue);

        $this->cursorThreshold = $this->progressValue->getMax();
        $this->units = $this->withCursor ? $units - 1 : $units;
    }

    protected function createFrameSequence(): string
    {
        return $this->createBar($this->progressValue->getValue());
    }

    private function createBar(float $progress): string
    {
        $p = (int)($progress * $this->units);

        $cursor =
            $this->withCursor
                ? $this->getCursor($progress)
                : '';

        return $this->sprite->getOpen() .
            str_repeat($this->sprite->getDone(), $p) .
            $cursor .
            str_repeat($this->sprite->getEmpty(), $this->units - $p) .
            $this->sprite->getClose();
    }

    private function getCursor(float $fraction): string
    {
        return $fraction >= $this->cursorThreshold
            ? $this->sprite->getDone()
            : $this->sprite->getCursor();
    }
}
