<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Core\Contract\IFloatValue;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\WidthDeterminer;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;

final class StepsProcedure extends AProgressValueProcedure
{
    private float $stepValue;

    public function __construct(IProgressValue $progressValue)
    {
        parent::__construct($progressValue);
        $this->stepValue = ($progressValue->getMax() - $progressValue->getMin()) / $progressValue->getSteps();
    }

    public function update(float $dt = null): IFrame
    {
        if ($this->progressValue->isFinished()) {
            if ($this->finishedDelay < 0) {
                return Frame::createEmpty();
            }
            $this->finishedDelay -= $dt;
        }
        $v = $this->createSteps($this->progressValue);
        return
            new Frame($v, WidthDeterminer::determine($v));
    }

    private function createSteps(IProgressValue $fractionValue): string
    {
        return
            sprintf('%s/%s', (int)($fractionValue->getValue() / $this->stepValue), $fractionValue->getSteps());
    }
}
