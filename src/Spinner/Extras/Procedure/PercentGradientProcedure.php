<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Contract\IFloatValue;
use AlecRabbit\Spinner\Extras\Contract\IProgressValue;
use AlecRabbit\Spinner\Extras\Frame\StyleFrame;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;
use RuntimeException;

/**
 * @psalm-suppress UnusedClass
 */
final class PercentGradientProcedure extends AFloatValueProcedure implements IStylePalette
{
    private int $count;

    public function __construct(
        IFloatValue $floatValue,
        private readonly IGradient $gradient,
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct($floatValue, options: $options);

        $this->count = $floatValue instanceof IProgressValue
            ? $floatValue->getSteps()
            : 100;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return new StyleFrame(
            style: new Style(
                fgColor: $this->getFgColor(),
            ),
        );
    }

    private function getFgColor(): IColor
    {
        return $this->gradient->getOne($this->getIndex(), $this->count);
    }

    protected function getIndex(): mixed
    {
        return min(
            $this->count,
            max(0, (int)($this->floatValue->getValue() * $this->count) - 1)
        );
    }

    protected function createSequenceFrame(string $sequence): ISequenceFrame
    {
        // TODO (2024-01-23 17:04) [Alec Rabbit]: refactor to remove this method
        throw new RuntimeException('Not implemented');
    }

    protected function createFrameSequence(): string
    {
        // TODO (2024-01-23 17:04) [Alec Rabbit]: refactor to remove this method
        throw new RuntimeException('Not implemented');
    }
}
