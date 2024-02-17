<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Revolver\A;

use AlecRabbit\Spinner\Contract\IHasSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Tests\Spinner\Unit\Extras\Revolver\A\Override\AFrameRevolverOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class AFrameRevolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameRevolver = $this->getTesteeInstance();

        self::assertInstanceOf(AFrameRevolverOverride::class, $frameRevolver);
    }

    public function getTesteeInstance(
        ?IHasSequenceFrame $frames = null,
        ?IInterval $interval = null,
    ): IFrameRevolver {
        return
            new AFrameRevolverOverride(
                frames: $frames ?? $this->getHasSequenceFramesMock(),
                interval: $interval ?? $this->getIntervalMock(),
            );
    }

    private function getHasSequenceFramesMock(): MockObject&IHasSequenceFrame
    {
        return $this->createMock(IHasSequenceFrame::class);
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canUpdate(): void
    {
        $interval = $this->getIntervalMock();

        $frames = $this->getHasSequenceFramesMock();
        $frames->method('getFrame')
            ->willReturnOnConsecutiveCalls(
                new CharFrame('1', 0),
                new CharFrame('2', 0),
            )
        ;

        $frameRevolver = $this->getTesteeInstance(
            frames: $frames,
            interval: $interval,
        );

        self::assertInstanceOf(AFrameRevolverOverride::class, $frameRevolver);
        self::assertEquals(new CharFrame('1', 0), $frameRevolver->getFrame());
        self::assertEquals(new CharFrame('2', 0), $frameRevolver->getFrame());
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $frameRevolver = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertInstanceOf(AFrameRevolverOverride::class, $frameRevolver);
        self::assertSame($interval, $frameRevolver->getInterval());
    }

    protected function getFrameCollectionMock(): MockObject&IFrameCollection
    {
        return $this->createMock(IFrameCollection::class);
    }

    protected function getOneElementFrameCollectionMock(): MockObject&IFrameCollection
    {
        $mockObject = $this->createMock(IFrameCollection::class);
        $mockObject->method('count')->willReturn(1);
        return $mockObject;
    }

    private function getGenerator(): Generator
    {
        yield new CharFrame('0', 0);
        yield new CharFrame('1', 0);
        yield new CharFrame('2', 0);
    }
}
