<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Color\Contract\Gradient\IGradient;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Contract\IProgressWrapper;
use AlecRabbit\Spinner\Extras\Frame\StyleFrame;
use AlecRabbit\Spinner\Extras\Procedure\A\AFloatValueProcedure;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;

/**
 * @psalm-suppress UnusedClass
 */
final class PercentGradientProcedure extends AFloatValueProcedure implements IStylePalette
{
    private int $count;

    public function __construct(
        IValueReference $reference,
        private readonly IGradient $gradient,
        IPaletteOptions $options = new PaletteOptions(interval: 1000),
    ) {
        parent::__construct(
            reference: $reference,
            options: $options
        );

        $this->count = $this->wrapper instanceof IProgressWrapper
            ? $this->wrapper->getSteps()
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
            max(0, (int)($this->wrapper->unwrap() * $this->count) - 1)
        );
    }
}
