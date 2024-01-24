<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Builder\Contract;

use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;
use AlecRabbit\Spinner\Extras\Color\IHexColorNormalizer;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;

interface IColorToAnsiCodeConverterBuilder
{
    public function build(): IColorToAnsiCodeConverter;

    public function withHexColorNormalizer(IHexColorNormalizer $hexColorNormalizer): IColorToAnsiCodeConverterBuilder;

    public function withColorCodesGetter(IColorCodesGetter $colorCodesGetter): IColorToAnsiCodeConverterBuilder;
}
