<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Contract\IFloatValue;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\WidthDeterminer;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;

final class StepsProcedure extends AFloatValueProcedure
{
    private float $stepValue;

    public function __construct(IFloatValue $progressValue)
    {
        parent::__construct($progressValue);
        $this->stepValue = ($progressValue->getMax() - $progressValue->getMin()) / $progressValue->getSteps();
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->floatValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return Frame::createEmpty();
            }
            $this->finishedDelay -= $dt;
        }
        $v = $this->createSteps($this->floatValue);
        return
            new Frame($v, WidthDeterminer::determine($v));
    }

    private function createSteps(IFloatValue $fractionValue): string
    {
        return
            sprintf('%s/%s', (int)($fractionValue->getValue() / $this->stepValue), $fractionValue->getSteps());
    }
}
