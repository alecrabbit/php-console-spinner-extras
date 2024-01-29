<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Helper;


use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Helper\ILoadValue;
use AlecRabbit\Spinner\Helper\LoadValue;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class LoadValueTest extends TestCase
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

        self::assertInstanceOf(LoadValue::class, $helper);
    }

    private function getTesteeInstance(
        int $current = 0,
        bool $even = true,
        ?IObserver $observer = null,
    ): ILoadValue {
        return new LoadValue(
            current: $current,
            even: $even,
            observer: $observer,
        );
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
                if ($subject instanceof ILoadValue) {
                    $this->values->append(
                        str_pad(decbin($subject->get()), 8, '0', STR_PAD_LEFT),
                    );
                }
            }
        };

        $load = $this->getTesteeInstance(observer: $observer);

        foreach ($data as $item) {
            [$element, $input] = $item;

            $load->add($input);
            $element && $expected->append(str_pad(decbin($element), 8, '0', STR_PAD_LEFT));
        }


        self::assertEquals( $expected->getArrayCopy(), $actual->getArrayCopy());
    }
}
