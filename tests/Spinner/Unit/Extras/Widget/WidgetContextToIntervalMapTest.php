<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Widget;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Extras\Contract\IWidgetContext;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Widget\Contract\IWidgetContextToIntervalMap;
use AlecRabbit\Spinner\Extras\Widget\WidgetContextToIntervalMap;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayAccess;
use ArrayObject;
use Countable;
use IteratorAggregate;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;
use WeakMap;

final class WidgetContextToIntervalMapTest extends TestCase
{
    public static function invalidOffsets(): iterable
    {
        yield from [
            [null],
            [1],
            [1.1],
            ['string'],
            [new stdClass()],
            [[]],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetContextToIntervalMap::class, $container);
    }

    public function getTesteeInstance(
        null|(ArrayAccess&Countable&IteratorAggregate) $map = null,
        null|ArrayObject $contexts = null,
    ): IWidgetContextToIntervalMap {
        return new WidgetContextToIntervalMap(
            map: $map ?? new WeakMap(),
            contexts: $contexts ?? new ArrayObject(),
        );
    }

    #[Test]
    public function canReturnCount(): void
    {
        $container = $this->getTesteeInstance();

        self::assertSame(0, $container->count());
        self::assertCount(0, $container);
    }

    #[Test]
    #[DataProvider('invalidOffsets')]
    public function returnsFalseOnOffsetExistsIfOffsetTypeIsOtherThanWidgetContext(mixed $incoming): void
    {
        $container = $this->getTesteeInstance();

        self::assertFalse($container->offsetExists($incoming));
    }

    #[Test]
    public function returnsBooleanOnOffsetExistsIfOffsetWidgetContext(): void
    {
        $container = $this->getTesteeInstance();

        self::assertIsBool($container->offsetExists($this->getWidgetContextMock()));
    }

    protected function getWidgetContextMock(): MockObject&IWidgetContext
    {
        return $this->createMock(IWidgetContext::class);
    }

    #[Test]
    public function nullValueReplacedWithFalseOnOffsetSet(): void
    {
        $map = new WeakMap();
        $container = $this->getTesteeInstance(
            map: $map,
        );

        $context = $this->getWidgetContextMock();
        $container->offsetSet($context, null);
        self::assertFalse($map->offsetGet($context));
    }

    #[Test]
    public function falseValueReplacedWithNullOnOffsetGet(): void
    {
        $map = new WeakMap();
        $contexts = new ArrayObject();
        $container = $this->getTesteeInstance(
            map: $map,
            contexts: $contexts,
        );

        $context = $this->getWidgetContextMock();
        $container->offsetSet($context, null);
        self::assertNull($container->offsetGet($context));
        self::assertContains($context, $contexts);
    }

    #[Test]
    public function getIteratorMethodTransformFalseValueToNull(): void
    {
        $map = new WeakMap();
        $contexts = new ArrayObject();
        $container = $this->getTesteeInstance(
            map: $map,
            contexts: $contexts,
        );

        $context1 = $this->getWidgetContextMock();
        $container->offsetSet($context1, null);
        self::assertFalse($map->offsetGet($context1));
        self::assertContains($context1, $contexts);

        $context2 = $this->getWidgetContextMock();
        $container->offsetSet($context2, null);
        self::assertFalse($map->offsetGet($context2));
        self::assertContains($context2, $contexts);

        $context3 = $this->getWidgetContextMock();
        $container->offsetSet($context3, null);
        self::assertFalse($map->offsetGet($context3));
        self::assertContains($context3, $contexts);

        $context4 = $this->getWidgetContextMock();
        $container->offsetSet($context4, null);
        self::assertFalse($map->offsetGet($context4));
        self::assertContains($context4, $contexts);

        foreach ($container as $item) {
            self::assertNull($item);
        }
    }

    #[Test]
    public function getIteratorMethodTransformFalseValueToNullButNotIntervalObjects(): void
    {
        $map = new WeakMap();
        $contexts = new ArrayObject();
        $container = $this->getTesteeInstance(
            map: $map,
            contexts: $contexts,
        );

        $context = $this->getWidgetContextMock();
        $interval = $this->getIntervalMock();

        $context1 = $this->getWidgetContextMock();
        $container->offsetSet($context1, null);
        self::assertFalse($map->offsetGet($context1));
        self::assertContains($context1, $contexts);

        $context2 = $this->getWidgetContextMock();
        $container->offsetSet($context2, null);
        self::assertFalse($map->offsetGet($context2));
        self::assertContains($context2, $contexts);

        // intentional position
        $container->offsetSet($context, $interval);
        self::assertSame($interval, $map->offsetGet($context));
        self::assertContains($context, $contexts);

        $context3 = $this->getWidgetContextMock();
        $container->offsetSet($context3, null);
        self::assertFalse($map->offsetGet($context3));
        self::assertContains($context3, $contexts);

        $context4 = $this->getWidgetContextMock();
        $container->offsetSet($context4, null);
        self::assertFalse($map->offsetGet($context4));
        self::assertContains($context4, $contexts);

        foreach ($container as $key => $item) {
            if ($key === $context) {
                self::assertSame($interval, $item);
                continue;
            }
            self::assertNull($item);
        }
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canGetValueByOffset(): void
    {
        $map = new WeakMap();
        $container = $this->getTesteeInstance(
            map: $map,
        );

        $context0 = $this->getWidgetContextMock();
        $context1 = $this->getWidgetContextMock();

        $interval0 = $this->getIntervalMock();
        $interval1 = $this->getIntervalMock();

        $container->offsetSet($context0, $interval0);
        $container->offsetSet($context1, $interval1);

        self::assertSame($interval1, $container->offsetGet($context1));
        self::assertSame($interval0, $container->offsetGet($context0));
    }

    #[Test]
    public function returnsTrueIfOffsetExists(): void
    {
        $map = new WeakMap();
        $container = $this->getTesteeInstance(
            map: $map,
        );

        $context0 = $this->getWidgetContextMock();
        $context1 = $this->getWidgetContextMock();

        $container->offsetSet($context0, null);
        $container->offsetSet($context1, $this->getIntervalMock());

        self::assertTrue($container->offsetExists($context0));
        self::assertTrue($container->offsetExists($context1));
    }

    #[Test]
    public function canUnsetOffset(): void
    {
        $map = new WeakMap();
        $contexts = new ArrayObject();
        $container = $this->getTesteeInstance(
            map: $map,
            contexts: $contexts,
        );

        $context0 = $this->getWidgetContextMock();
        $context1 = $this->getWidgetContextMock();

        $container->offsetSet($context0, null);
        $container->offsetSet($context1, $this->getIntervalMock());

        self::assertTrue($container->offsetExists($context0));
        self::assertTrue($container->offsetExists($context1));
        self::assertContains($context0, $contexts);
        self::assertContains($context1, $contexts);

        $container->offsetUnset($context0);
        $container->offsetUnset($context1);

        self::assertFalse($container->offsetExists($context0));
        self::assertFalse($container->offsetExists($context1));
        self::assertNotContains($context0, $contexts);
        self::assertNotContains($context1, $contexts);
    }

    #[Test]
    public function noExceptionThrownOnOffsetUnsetIfOffsetDoesNotExist(): void
    {
        $map = new WeakMap();
        $container = $this->getTesteeInstance(
            map: $map,
        );

        $container->offsetUnset($this->getWidgetContextMock());
        $container->offsetUnset($this->getWidgetContextMock());

        // dummy assertion to prevent risky test
        self::assertCount(0, $container);
    }

    #[Test]
    public function throwsIfBeingSetValueIsInvalid(): void
    {
        $container = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Invalid value type.');

        $context = $this->getWidgetContextMock();

        $container->offsetSet($context, 'invalid');

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsOnOffsetSetIfOffsetIsOfInvalidType(): void
    {
        $container = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Invalid offset type.');

        $interval = $this->getIntervalMock();

        $container->offsetSet('invalid', $interval);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsOnOffsetGetIfOffsetIsOfInvalidType(): void
    {
        $container = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Invalid offset type.');

        $container->offsetGet('invalid');

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsOnOffsetUnsetIfOffsetIsOfInvalidType(): void
    {
        $container = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Invalid offset type.');

        $container->offsetUnset('invalid');

        self::fail('Exception was not thrown.');
    }
}
