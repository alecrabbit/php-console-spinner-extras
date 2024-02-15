<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Revolver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Revolver\StyleFrameRevolver;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class StyleFrameRevolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameRevolver = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRevolver::class, $frameRevolver);
    }

    public function getTesteeInstance(
        ?Traversable $frames = null,
        ?IInterval $interval = null,
        ?ITolerance $tolerance = null,
        ?IStyleRenderer $styleRenderer = null,
    ): IFrameRevolver {
        return
            new StyleFrameRevolver(
                frames: $frames ?? $this->getGenerator(),
                interval: $interval ?? $this->getIntervalMock(),
                tolerance: $tolerance ?? $this->getToleranceMock(),
                styleRenderer: $styleRenderer ?? $this->getStyleRendererMock(),
            );
    }

    private function getGenerator(): Generator
    {
        yield new StyleFrame('0', 0);
        yield new StyleFrame('1', 0);
        yield new StyleFrame('2', 0);
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    private function getStyleRendererMock(): MockObject&IStyleRenderer
    {
        return $this->createMock(IStyleRenderer::class);
    }

    #[Test]
    public function canUpdate(): void
    {
        $interval = $this->getIntervalMock();

        $frames = $this->getGenerator();

        $frameRevolver = $this->getTesteeInstance(
            frames: $frames,
            interval: $interval,
        );

        self::assertInstanceOf(StyleFrameRevolver::class, $frameRevolver);
        self::assertEquals(new StyleFrame('1', 0), $frameRevolver->getFrame());
        self::assertEquals(new StyleFrame('2', 0), $frameRevolver->getFrame());
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

    #[Test]
    public function throwsIfFramesIsNotAGenerator(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('Frames must be an instance of infinite Generator. "ArrayObject" given.');

        $this->getTesteeInstance(
            frames: new ArrayObject(),
        );
    }

    protected function getFrameCollectionMock(): MockObject&IFrameCollection
    {
        return $this->createMock(IFrameCollection::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    protected function getOneElementFrameCollectionMock(): MockObject&IFrameCollection
    {
        $mockObject = $this->createMock(IFrameCollection::class);
        $mockObject->method('count')->willReturn(1);
        return $mockObject;
    }
}
