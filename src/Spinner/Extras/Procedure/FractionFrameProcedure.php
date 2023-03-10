<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Contract\IFloatValue;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\WidthDeterminer;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;

final class FractionFrameProcedure extends AFloatValueProcedure
{
    private const FRAMES = [
        ' ',
        '▁',
        '▂',
        '▃',
        '▄',
        '▅',
        '▆',
        '▇',
        '█',
    ];
    private int $steps;

    public function __construct(
        IFloatValue $progressValue,
        protected array $frames = self::FRAMES, // TODO (2023-01-26 14:45) [Alec Rabbit]: remove array type -> use smth like "IFramesCollection"
    )
    {
        parent::__construct($progressValue);
        $this->steps = count($frames) - 1;
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->floatValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return Frame::createEmpty();
            }
            $this->finishedDelay -= $dt;
        }
        $v = $this->createColumn($this->floatValue->getValue());
        return
            new Frame($v, WidthDeterminer::determine($v));
    }

    private function createColumn(float $progress): string
    {
        $p = (int)($progress * $this->steps);
        return
            $this->frames[$p]; // TODO (2023-01-26 14:45) [Alec Rabbit]: return IFrame from "IFramesCollection"
    }
}
