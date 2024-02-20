<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\ICharFrameFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CharFrameFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameFactory = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameFactory::class, $frameFactory);
    }

    public function getTesteeInstance(
        ?IWidthMeasurer $widthMeasurer = null,
    ): ICharFrameFactory {
        return new CharFrameFactory(
            widthMeasurer: $widthMeasurer ?? $this->getWidthMeasurerMock(),
        );
    }
    protected function getWidthMeasurerMock(): MockObject&IWidthMeasurer
    {
        return $this->createMock(IWidthMeasurer::class);
    }
    #[Test]
    public function canCreate(): void
    {
        $frameFactory = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameFactory::class, $frameFactory);
        self::assertInstanceOf(CharSequenceFrame::class, $frameFactory->create(''));
    }
}
