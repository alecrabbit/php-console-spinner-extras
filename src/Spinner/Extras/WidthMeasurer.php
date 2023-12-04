<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IWidthGetter;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use Closure;
use ReflectionFunction;

final class WidthMeasurer implements IWidthMeasurer
{
    public function __construct(
        protected IWidthGetter $widthGetter,
    ) {
    }

    public function measureWidth(string $string): int
    {
        return $this->widthGetter->getWidth($string);
    }
}
