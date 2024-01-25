<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Extras\Color\Builder\Contract\IColorToAnsiCodeConverterBuilder;
use AlecRabbit\Spinner\Extras\Color\Contract\IHexColorNormalizer;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorCodesGetterFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorToAnsiCodeConverterFactory;

final readonly class ColorToAnsiCodeConverterFactory implements IColorToAnsiCodeConverterFactory
{
    public function __construct(
        private IHexColorNormalizer $hexColorNormalizer,
        private IColorCodesGetterFactory $colorCodesGetterFactory,
        private IColorToAnsiCodeConverterBuilder $colorToAnsiCodeConverterBuilder,
    ) {
    }


    public function create(): IColorToAnsiCodeConverter
    {
        return $this->colorToAnsiCodeConverterBuilder
            ->withHexColorNormalizer($this->hexColorNormalizer)
            ->withColorCodesGetter($this->colorCodesGetterFactory->create())
            ->build()
        ;
    }
}
