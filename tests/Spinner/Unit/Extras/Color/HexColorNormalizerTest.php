<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color;


use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\RGB;
use AlecRabbit\Spinner\Extras\Color\Contract\IHexColorNormalizer;
use AlecRabbit\Spinner\Extras\Color\HexColorNormalizer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HexColorNormalizerTest extends TestCase
{
    public static function canNormalizeDataProvider(): iterable
    {
        yield from [
            [IHexColor::class, 'red'],
            [IHexColor::class, RGB::from('red')],
            [IHexColor::class, Hex::from('red')],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $normalizer = $this->getTesteeInstance();

        self::assertInstanceOf(HexColorNormalizer::class, $normalizer);
    }

    private function getTesteeInstance(): IHexColorNormalizer
    {
        return new HexColorNormalizer();
    }

    #[Test]
    #[DataProvider('canNormalizeDataProvider')]
    public function canNormalize(string $expectedClass, IColor|string $input): void
    {
        $normalizer = $this->getTesteeInstance();

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($expectedClass, $normalizer->normalize($input));

        if ($input instanceof IHexColor) {
            self::assertSame($input, $normalizer->normalize($input));
        }
    }
}
