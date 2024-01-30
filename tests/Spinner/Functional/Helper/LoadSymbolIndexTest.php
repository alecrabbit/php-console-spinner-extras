<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Helper;


use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Extras\Value\ILoadValue;
use AlecRabbit\Spinner\Extras\Value\LoadValue;
use AlecRabbit\Spinner\Helper\ILoadSymbolIndex;
use AlecRabbit\Spinner\Helper\LoadSymbolIndex;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoadSymbolIndexTest extends TestCase
{
    public static function canGetDataProvider(): iterable
    {
        yield from [
            [
                [
                    [null, 0],
                    [0b00000011, 0.5],
                    [null, 0.5],
                    [0b00110000, 0.0],
                    [null, 0.29],
                    [0b00011111, 1],
                    [null, 0.8],
                    [0b01110000, 0.0],
                ],
            ],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $helper = $this->getTesteeInstance();

        self::assertInstanceOf(LoadSymbolIndex::class, $helper);
    }

    private function getTesteeInstance(
        ?ILoadValue $loadValue = null,
        int $current = 0,
        bool $even = true,
        ?IObserver $observer = null,
    ): ILoadSymbolIndex {
        return new LoadSymbolIndex(
            loadValue: $loadValue ?? $this->getLoadValueMock(),
            current: $current,
            even: $even,
            observer: $observer,
        );
    }

    private function getLoadValueMock(): MockObject&ILoadValue
    {
        return $this->createMock(ILoadValue::class);
    }

    #[Test]
    #[DataProvider('canGetDataProvider')]
    public function canGet(array $data): void
    {
        $expected = new \ArrayObject();
        $actual = new \ArrayObject();

        $observer = new class(values: $actual) implements IObserver {
            public function __construct(
                private readonly \ArrayObject $values,
            ) {
            }

            public function update(ISubject $subject): void
            {
                if ($subject instanceof ILoadSymbolIndex) {
                    $this->values->append(
                        str_pad(decbin($subject->get()), 8, '0', STR_PAD_LEFT),
                    );
                }
            }
        };

        $loadValue = new LoadValue();

        $this->getTesteeInstance(
            loadValue: $loadValue,
            observer: $observer,
        );

        foreach ($data as $item) {
            [$element, $input] = $item;

            $loadValue->setLoad($input);
            $element && $expected->append(str_pad(decbin($element), 8, '0', STR_PAD_LEFT));
        }


        self::assertEquals($expected->getArrayCopy(), $actual->getArrayCopy());
    }
}
