<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\AnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IAnsiCode;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IColorToAnsiCodeConverter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class AnsiColorParserTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $colorParser = $this->getTesteeInstance();

        self::assertInstanceOf(AnsiColorParser::class, $colorParser);
    }

    protected function getTesteeInstance(
        ?IColorToAnsiCodeConverter $converter = null,
    ): IAnsiColorParser {
        return new AnsiColorParser(
            converter: $converter ?? $this->getColorToAnsiCodeConverterMock(),
        );
    }

    private function getColorToAnsiCodeConverterMock(): MockObject&IColorToAnsiCodeConverter
    {
        return $this->createMock(IColorToAnsiCodeConverter::class);
    }

    #[Test]
    public function invokesAnsiConvertMethod(): void
    {
        $converter = $this->getColorToAnsiCodeConverterMock();
        $color = '#ffaacc';
        $result = 'result';
        $ansiCode = $this->getAnsiCodeMock();
        $ansiCode
            ->expects(self::once())
            ->method('toString')
            ->willReturn($result)
        ;
        $converter
            ->expects(self::once())
            ->method('convert')
            ->with(self::identicalTo($color))
            ->willReturn($ansiCode)
        ;
        $colorParser = $this->getTesteeInstance(converter: $converter);

        self::assertSame($result, $colorParser->parseColor($color));
    }

    private function getAnsiCodeMock(): MockObject&IAnsiCode
    {
        return $this->createMock(IAnsiCode::class);
    }

    #[Test]
    public function returnsEmptyStringIfColorIsNull(): void
    {
        $converter = $this->getColorToAnsiCodeConverterMock();
        $color = null;
        $result = '';

        $converter
            ->expects(self::never())
            ->method('convert')
        ;
        $colorParser = $this->getTesteeInstance(converter: $converter);

        self::assertSame($result, $colorParser->parseColor($color));
    }

    #[Test]
    public function returnsEmptyStringIfColorIsEmptyString(): void
    {
        $converter = $this->getColorToAnsiCodeConverterMock();
        $color = '';
        $result = '';

        $converter
            ->expects(self::never())
            ->method('convert')
        ;
        $colorParser = $this->getTesteeInstance(converter: $converter);

        self::assertSame($result, $colorParser->parseColor($color));
    }

    #[Test]
    public function emptyColorReturnsEmptyParsedString(): void
    {
        $colorParser = $this->getTesteeInstance();

        self::assertSame('', $colorParser->parseColor(''));
    }
}
