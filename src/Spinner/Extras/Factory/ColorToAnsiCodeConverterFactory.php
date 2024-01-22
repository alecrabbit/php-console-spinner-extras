<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IColorToAnsiCodeConverterFactory;
use RuntimeException;

final readonly class ColorToAnsiCodeConverterFactory implements IColorToAnsiCodeConverterFactory
{

    public function create(StylingMethodMode $styleMode): IColorToAnsiCodeConverter
    {
        // TODO: Implement create() method.
        throw new RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
