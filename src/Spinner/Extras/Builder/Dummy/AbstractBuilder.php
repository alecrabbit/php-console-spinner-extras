<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Builder\Dummy;

/**
 * @internal
 */
abstract class AbstractBuilder
{
    abstract public function build(): mixed;

    /**
     * @param mixed $value
     * @return ($value is IDummy ? true : false)
     */
    protected function isDummy(mixed $value): bool
    {
        return $value instanceof IDummy;
    }

    abstract protected function validate(): void;
}
