<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Extras\Contract\IProgressBarSprite;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

use function AlecRabbit\WCWidth\wcswidth;

/**
 * @deprecated
 * @psalm-suppress UnusedClass
 */
final class ProgressBarProcedure extends AProgressValueProcedure
{
    private const UNITS = 5;
    private string $open;
    private string $close;
    private string $empty;
    private string $done;
    private string $cursor;
    private float $cursorThreshold;

    public function __construct(
        IProgressValue $progressValue,
        private readonly ?IProgressBarSprite $sprite = null,
        private int $units = self::UNITS,
        private readonly bool $withCursor = true,
    ) {
        parent::__construct($progressValue);

        $this->init();
    }

    protected function init(): void
    {
        $this->cursorThreshold = $this->progressValue->getMax();
        $this->units = $this->withCursor ? $this->units - 1 : $this->units;
        $this->open = $this->sprite ? $this->sprite->getOpen() : '[';
        $this->close = $this->sprite ? $this->sprite->getClose() : ']';
        $this->empty = $this->sprite ? $this->sprite->getEmpty() : '-';
        $this->done = $this->sprite ? $this->sprite->getDone() : '=';
        $this->cursor = $this->sprite ? $this->sprite->getCursor() : '>';
    }

    private function getCursor(float $fraction): string
    {
        return $fraction >= $this->cursorThreshold
            ? $this->done
            : $this->cursor;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        if ($this->progressValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return new CharFrame('', 0);
            }
            $this->finishedDelay -= $dt ?? 0.0;
        }
        $v = $this->createBar($this->progressValue->getValue());
        return new CharFrame($v, wcswidth($v)); // FIXME (2023-12-14 14:21) [Alec Rabbit]: direct function call
    }

    private function createBar(float $progress): string
    {
        $p = (int)($progress * $this->units);

        $cursor =
            $this->withCursor
                ? $this->getCursor($progress)
                : '';

        return $this->open .
            str_repeat($this->done, $p) .
            $cursor .
            str_repeat($this->empty, $this->units - $p) .
            $this->close;
    }
}
