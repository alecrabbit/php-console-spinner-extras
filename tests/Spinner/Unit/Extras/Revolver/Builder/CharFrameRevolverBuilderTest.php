<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Revolver\Builder;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IHasSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Revolver\Builder\CharFrameRevolverBuilder;
use AlecRabbit\Spinner\Extras\Revolver\CharFrameRevolver;
use AlecRabbit\Tests\TestCase\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CharFrameRevolverBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameRevolverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameRevolverBuilder::class, $frameRevolverBuilder);
    }

    public function getTesteeInstance(): IFrameRevolverBuilder
    {
        return new CharFrameRevolverBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $frames = $this->getHasSequenseFrameMock();

        $frameRevolverBuilder = $this->getTesteeInstance();
        $revolver =
            $frameRevolverBuilder
                ->withFrames($frames)
                ->withInterval($this->getIntervalMock())
                ->withTolerance($this->getToleranceMock())
                ->build()
        ;

        self::assertInstanceOf(CharFrameRevolverBuilder::class, $frameRevolverBuilder);
        self::assertInstanceOf(CharFrameRevolver::class, $revolver);
    }

    private function getHasSequenseFrameMock(): MockObject&IHasSequenceFrame
    {
        return $this->createMock(IHasSequenceFrame::class);
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
                    ->build()
            ;
            self::assertInstanceOf(CharFrameRevolverBuilder::class, $frameRevolverBuilder);
            self::assertInstanceOf(CharFrameRevolver::class, $revolver);
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
                    ->build()
            ;
            self::assertInstanceOf(CharFrameRevolverBuilder::class, $frameRevolverBuilder);
            self::assertInstanceOf(CharFrameRevolver::class, $revolver);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
