<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IWidgetContext;
use AlecRabbit\Spinner\Extras\Widget\Contract\IWidgetContextToIntervalMap;
use ArrayAccess;
use ArrayObject;
use Countable;
use IteratorAggregate;
use Traversable;
use WeakMap;

/**
 * @template TKey of IWIdgetContext
 * @template TValue of IInterval|null
 *
 * @implements IWidgetContextToIntervalMap<TKey, TValue>
 */
final readonly class WidgetContextToIntervalMap implements IWidgetContextToIntervalMap
{
    public function __construct(
        private ArrayAccess&Countable&IteratorAggregate $map = new WeakMap(),
        private ArrayObject $contexts = new ArrayObject(),
    ) {
    }

    public function getIterator(): Traversable
    {
        /**
         * @var IWidgetContext $key
         * @var IInterval|false|null $value
         */
        foreach ($this->map as $key => $value) {
            if ($value === false) {
                $value = null;
            }
            yield $key => $value;
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        if (!$offset instanceof IWidgetContext) {
            return false;
        }
        return $this->map->offsetExists($offset);
    }

    /** @inheritDoc */
    public function offsetGet(mixed $offset): ?IInterval
    {
        $this->assertOffset($offset);

        /** @var IInterval|false|null $value */
        $value = $this->map->offsetGet($offset);

        if ($value === false) {
            return null;
        }

        return $value;
    }

    private function assertOffset(mixed $offset): void
    {
        if (!$offset instanceof IWidgetContext) {
            throw new InvalidArgument('Invalid offset type.');
        }
    }

    /** @inheritDoc */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->assertOffset($offset);
        $this->assertValue($value);

        $this->map->offsetSet(
            $offset,
            $value ?? false
        );

        $this->contexts->append($offset);
    }

    private function assertValue(mixed $value): void
    {
        if ($value === null) {
            return;
        }
        if (!$value instanceof IInterval) {
            throw new InvalidArgument('Invalid value type.');
        }
    }

    /** @inheritDoc */
    public function offsetUnset(mixed $offset): void
    {
        $this->assertOffset($offset);

        $this->map->offsetUnset($offset);

        $key = array_search($offset, $this->contexts->getArrayCopy(), true);
        if ($key !== false) {
            $this->contexts->offsetUnset($key);
        }
    }

    public function count(): int
    {
        return $this->map->count();
    }
}
