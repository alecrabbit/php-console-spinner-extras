<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras;

use AlecRabbit\Spinner\Extras\Contract\IWidthGetter;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\WidthMeasurer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidthMeasurerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $measurer = $this->getTesteeInstance();

        self::assertInstanceOf(WidthMeasurer::class, $measurer);
    }

    public function getTesteeInstance(
        ?IWidthGetter $widthGetter = null,
    ): IWidthMeasurer {
        return new WidthMeasurer(
            widthGetter: $widthGetter ?? $this->getWidthGetterMock(),
        );
    }

    private function getWidthGetterMock(): MockObject&IWidthGetter
    {
        return $this->createMock(IWidthGetter::class);
    }

    #[Test]
    public function canMeasureWidth(): void
    {
        $value = 'test';

        $widthGetter = $this->getWidthGetterMock();
        $widthGetter
            ->expects(self::once())
            ->method('getWidth')
            ->with(self::identicalTo($value))
            ->willReturn(4)
        ;

        $measurer = $this->getTesteeInstance(
            widthGetter: $widthGetter,
        );

        $width = $measurer->measureWidth($value);

        self::assertSame(4, $width);
    }
}
