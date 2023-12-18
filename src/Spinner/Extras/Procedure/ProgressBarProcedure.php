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
    private float $cursorThreshold;

    public function __construct(
        IProgressValue $progressValue,
        private readonly IProgressBarSprite $sprite = new ProgressBarSprite(),
        private int $units = self::UNITS,
        private readonly bool $withCursor = true,
    ) {
        parent::__construct($progressValue);

        $this->cursorThreshold = $this->progressValue->getMax();
        $this->units = $this->withCursor ? $this->units - 1 : $this->units;
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
