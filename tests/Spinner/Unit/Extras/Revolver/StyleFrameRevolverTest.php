<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Revolver;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IHasSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Revolver\StyleFrameRevolver;
use AlecRabbit\Tests\TestCase\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StyleFrameRevolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameRevolver = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRevolver::class, $frameRevolver);
    }

    public function getTesteeInstance(
        ?IHasFrame $frames = null,
        ?IInterval $interval = null,
        ?IStyleRenderer $styleRenderer = null,
    ): IFrameRevolver {
        return
            new StyleFrameRevolver(
                frames: $frames ?? $this->getHasSequenceFrameMock(),
                interval: $interval ?? $this->getIntervalMock(),
                styleRenderer: $styleRenderer ?? $this->getStyleRendererMock(),
            );
    }

    private function getHasSequenceFrameMock(): MockObject&IHasSequenceFrame
    {
        return $this->createMock(IHasSequenceFrame::class);
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getStyleRendererMock(): MockObject&IStyleRenderer
    {
        return $this->createMock(IStyleRenderer::class);
    }

    #[Test]
    public function canUpdate(): void
    {
        $interval = $this->getIntervalMock();

        $frames = $this->getHasSequenceFrameMock();
        $frames->method('getFrame')
            ->willReturnOnConsecutiveCalls(
                new StyleSequenceFrame('1', 0),
                new StyleSequenceFrame('2', 0),
            )
        ;

        $frameRevolver = $this->getTesteeInstance(
            frames: $frames,
            interval: $interval,
        );

        self::assertInstanceOf(StyleFrameRevolver::class, $frameRevolver);
        self::assertEquals(new StyleSequenceFrame('1', 0), $frameRevolver->getFrame());
        self::assertEquals(new StyleSequenceFrame('2', 0), $frameRevolver->getFrame());
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

        $frameRevolver = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertInstanceOf(StyleFrameRevolver::class, $frameRevolver);
        self::assertSame($interval, $frameRevolver->getInterval());
    }

    protected function getFrameCollectionMock(): MockObject&IFrameCollection
    {
        return $this->createMock(IFrameCollection::class);
    }

    protected function getSequenceFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    protected function getOneElementFrameCollectionMock(): MockObject&IFrameCollection
    {
        $mockObject = $this->createMock(IFrameCollection::class);
        $mockObject->method('count')->willReturn(1);
        return $mockObject;
    }

    private function getGenerator(): Generator
    {
        yield new StyleSequenceFrame('0', 0);
        yield new StyleSequenceFrame('1', 0);
        yield new StyleSequenceFrame('2', 0);
    }
}
