<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\Contract\ISecondsToDurationStringConverter;

final class SecondsToDurationStringConverter implements ISecondsToDurationStringConverter
{

    public function convert(int $seconds): string
    {
        return sprintf('PT%dS', $seconds);    }
}
