<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Revolver\Builder;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Revolver\Builder\Contract\IStyleFrameRevolverBuilder;
use AlecRabbit\Spinner\Extras\Revolver\Builder\StyleFrameRevolverBuilder;
use AlecRabbit\Spinner\Extras\Revolver\StyleFrameRevolver;
use AlecRabbit\Tests\TestCase\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StyleFrameRevolverBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameRevolverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRevolverBuilder::class, $frameRevolverBuilder);
    }

    public function getTesteeInstance(): IStyleFrameRevolverBuilder
    {
        return new StyleFrameRevolverBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $frames = $this->getGenerator();

        $frameRevolverBuilder = $this->getTesteeInstance();
        $revolver =
            $frameRevolverBuilder
                ->withFrames($frames)
                ->withInterval($this->getIntervalMock())
                ->withTolerance($this->getToleranceMock())
                ->withStyleRenderer($this->getStyleRendererMock())
                ->build()
        ;

        self::assertInstanceOf(StyleFrameRevolverBuilder::class, $frameRevolverBuilder);
        self::assertInstanceOf(StyleFrameRevolver::class, $revolver);
    }

    private function getGenerator(): Generator
    {
        yield new CharFrame('0', 0);
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
    public function throwsIfFrameIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Frame collection is not set.';

        $test = function (): void {
            $frameRevolverBuilder = $this->getTesteeInstance();

            $revolver =
                $frameRevolverBuilder
                    ->withInterval($this->getIntervalMock())
                    ->withTolerance($this->getToleranceMock())
                    ->withStyleRenderer($this->getStyleRendererMock())
                    ->build()
            ;
            self::assertInstanceOf(StyleFrameRevolverBuilder::class, $frameRevolverBuilder);
            self::assertInstanceOf(StyleFrameRevolver::class, $revolver);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfIntervalIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Interval is not set.';

        $test = function (): void {
            $frameRevolverBuilder = $this->getTesteeInstance();

            $revolver =
                $frameRevolverBuilder
                    ->withFrames($this->getGenerator())
                    ->withTolerance($this->getToleranceMock())
                    ->withStyleRenderer($this->getStyleRendererMock())
                    ->build()
            ;
            self::assertInstanceOf(StyleFrameRevolverBuilder::class, $frameRevolverBuilder);
            self::assertInstanceOf(StyleFrameRevolver::class, $revolver);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfStyleRendererIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style renderer is not set.';

        $test = function (): void {
            $frameRevolverBuilder = $this->getTesteeInstance();

            $revolver =
                $frameRevolverBuilder
                    ->withFrames($this->getGenerator())
                    ->withInterval($this->getIntervalMock())
                    ->withTolerance($this->getToleranceMock())
                    ->build()
            ;
            self::assertInstanceOf(StyleFrameRevolverBuilder::class, $frameRevolverBuilder);
            self::assertInstanceOf(StyleFrameRevolver::class, $revolver);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
