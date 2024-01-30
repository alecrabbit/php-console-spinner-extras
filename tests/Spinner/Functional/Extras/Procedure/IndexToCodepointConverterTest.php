<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras\Procedure;


use AlecRabbit\Spinner\Extras\Procedure\BrailleIndexConverter;
use AlecRabbit\Spinner\Extras\Procedure\IIndexConverter;
use AlecRabbit\Spinner\Extras\Procedure\IIndexToCodepointConverter;
use AlecRabbit\Spinner\Extras\Procedure\IndexToCodepointConverter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class IndexToCodepointConverterTest extends TestCase
{
    public static function canGetDataProvider(): iterable
    {
        yield from [
            [mb_ord('⠀'), -19],
            [mb_ord('⣿'), 2956],
            [mb_ord('⠀'), 0b00000000],
            [mb_ord('⣿'), 0b11111111],
            [mb_ord('⢸'), 0b00001111],
            [mb_ord('⡇'), 0b11110000],
            [mb_ord('⣀'), 0b00010001],
            [mb_ord('⣤'), 0b00110011],
            [mb_ord('⡀'), 0b00010000],
            [mb_ord('⢀'), 0b00000001],
            [mb_ord('⡄'), 0b00110000],
            [mb_ord('⣶'), 0b01110111],
            [mb_ord('⣦'), 0b01110011],
            [mb_ord('⣴'), 0b00110111],
            [mb_ord('⣄'), 0b00110001],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $converter = $this->getTesteeInstance();

        self::assertInstanceOf(IndexToCodepointConverter::class, $converter);
    }

    private function getTesteeInstance(
        ?IIndexConverter $indexConverter = null,
    ): IIndexToCodepointConverter {
        return new IndexToCodepointConverter(
            indexConverter: $indexConverter ?? new BrailleIndexConverter(),
        );
    }

    #[Test]
    #[DataProvider('canGetDataProvider')]
    public function canGet(int $expected, mixed $input): void
    {
        $converter = $this->getTesteeInstance();

        self::assertEquals($expected, $converter->getCodepoint($input));
    }
}
