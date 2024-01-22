<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras\Color\Style;

use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Color\Style\StyleOptions;
use AlecRabbit\Spinner\Extras\Contract\Style\StyleOption;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class StyleTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $style = new Style();

        self::assertNull($style->getFgColor());
        self::assertNull($style->getBgColor());
        self::assertNull($style->getOptions());
        self::assertSame('%s', $style->getFormat());
        self::assertSame(0, $style->getWidth());
        self::assertTrue($style->isEmpty());
        self::assertFalse($style->isOptionsOnly());
        self::assertFalse($style->hasOptions());
    }

    #[Test]
    public function canBeInstantiatedWithValues(): void
    {
        $fgColor = '#000000';
        $bgColor = '#000000';
        $options = new StyleOptions(StyleOption::BOLD);
        $format = ' %s ';
        $width = 2;
        $style = new Style(
            fgColor: $fgColor,
            bgColor: $bgColor,
            options: $options,
            format: $format,
            width: $width,
        );

        self::assertSame($fgColor, $style->getFgColor());
        self::assertSame($bgColor, $style->getBgColor());
        self::assertSame($options, $style->getOptions());
        self::assertSame($format, $style->getFormat());
        self::assertSame($width, $style->getWidth());
        self::assertFalse($style->isEmpty());
        self::assertFalse($style->isOptionsOnly());
        self::assertTrue($style->hasOptions());
    }

    #[Test]
    public function canBeInstantiatedWithOptionsOnly(): void
    {
        $options = new StyleOptions(StyleOption::BOLD);
        $style = new Style(
            options: $options,
        );

        self::assertNull($style->getFgColor());
        self::assertNull($style->getBgColor());
        self::assertSame($options, $style->getOptions());
        self::assertFalse($style->isEmpty());
        self::assertTrue($style->isOptionsOnly());
        self::assertTrue($style->hasOptions());
    }
}
