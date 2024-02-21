<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Procedure;


use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Extras\Procedure\Contract\IFloatToIndex;
use AlecRabbit\Spinner\Extras\Procedure\Contract\IPercentageSymbolIndex;
use AlecRabbit\Spinner\Extras\Procedure\FloatToIndex;
use AlecRabbit\Spinner\Extras\Procedure\FloatToIndexFilled;
use AlecRabbit\Spinner\Extras\Procedure\PercentageSymbolIndex;
use AlecRabbit\Spinner\Extras\Value\IPercentValue;
use AlecRabbit\Spinner\Extras\Value\PercentValue;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class PercentageSymbolIndexTest extends TestCase
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

        self::assertInstanceOf(PercentageSymbolIndex::class, $helper);
    }

    private function getTesteeInstance(
        ?IPercentValue $loadValue = null,
        int $current = 0,
        bool $even = true,
        ?IFloatToIndex $floatToIndex = null,
        ?IObserver $observer = null,
    ): IPercentageSymbolIndex {
        return new PercentageSymbolIndex(
            loadValue: $loadValue ?? $this->getLoadValueMock(),
            current: $current,
            even: $even,
            floatToIndex: $floatToIndex ?? new FloatToIndex(),
            observer: $observer,
        );
    }

    private function getLoadValueMock(): MockObject&IPercentValue
    {
        return $this->createMock(IPercentValue::class);
    }

    #[Test]
    #[DataProvider('canGetDataProvider')]
    public function canGet(array $data): void
    {
        $expected = new ArrayObject();
        $actual = new ArrayObject();

        $observer = new class(values: $actual) implements IObserver {
            public function __construct(
                private readonly ArrayObject $values,
            ) {
            }

            public function update(ISubject $subject): void
            {
                if ($subject instanceof IPercentageSymbolIndex) {
                    $this->values->append(
                        str_pad(decbin($subject->get()), 8, '0', STR_PAD_LEFT),
                    );
                }
            }
        };

        $loadValue = new PercentValue();

        $this->getTesteeInstance(
            loadValue: $loadValue,
            floatToIndex: new FloatToIndexFilled(),
            observer: $observer,
        );

        foreach ($data as $item) {
            [$element, $input] = $item;

            $loadValue->setPercent($input);
            $element && $expected->append(str_pad(decbin($element), 8, '0', STR_PAD_LEFT));
        }


        self::assertEquals($expected->getArrayCopy(), $actual->getArrayCopy());
    }
}
