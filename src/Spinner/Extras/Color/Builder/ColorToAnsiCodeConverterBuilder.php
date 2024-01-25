<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Color\Builder;

use AlecRabbit\Spinner\Extras\Builder\Dummy\AbstractBuilder;
use AlecRabbit\Spinner\Extras\Builder\Dummy\Dummy;
use AlecRabbit\Spinner\Extras\Builder\Dummy\IDummy;
use AlecRabbit\Spinner\Extras\Color\Builder\Contract\IColorToAnsiCodeConverterBuilder;
use AlecRabbit\Spinner\Extras\Color\ColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\Contract\IHexColorNormalizer;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;
use LogicException;

final class ColorToAnsiCodeConverterBuilder extends AbstractBuilder implements IColorToAnsiCodeConverterBuilder
{
    public function __construct(
        private IDummy|IHexColorNormalizer $hexColorNormalizer = new Dummy(),
        private IDummy|IColorCodesGetter $colorCodesGetter = new Dummy(),
    ) {
    }

    /**
     * @psalm-suppress PossiblyInvalidArgument
     */
    public function build(): IColorToAnsiCodeConverter
    {
        $this->validate();

        return new ColorToAnsiCodeConverter(
            hexColorNormalizer: $this->hexColorNormalizer,
            colorCodesGetter: $this->colorCodesGetter,
        );
    }

    protected function validate(): void
    {
        match (true) {
            $this->isDummy($this->hexColorNormalizer) => throw new LogicException(
                'HexColorNormalizer is not set.'
            ),
            $this->isDummy($this->colorCodesGetter) => throw new LogicException(
                'ColorCodesGetter is not set.'
            ),
            default => null,
        };
    }

    public function withHexColorNormalizer(IHexColorNormalizer $hexColorNormalizer): IColorToAnsiCodeConverterBuilder
    {
        $clone = clone $this;
        $clone->hexColorNormalizer = $hexColorNormalizer;
        return $clone;
    }

    public function withColorCodesGetter(IColorCodesGetter $colorCodesGetter): IColorToAnsiCodeConverterBuilder
    {
        $clone = clone $this;
        $clone->colorCodesGetter = $colorCodesGetter;
        return $clone;
    }
}
