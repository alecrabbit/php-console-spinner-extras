<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Extras\Factory\CharFrameRevolverFactory;
use AlecRabbit\Spinner\Extras\Pattern\Contract\IInfinitePattern;
use AlecRabbit\Spinner\Extras\Revolver\Builder\Contract\ICharFrameRevolverBuilder;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class CharFrameRevolverFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $charRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameRevolverFactory::class, $charRevolverFactory);
    }

    public function getTesteeInstance(
        ?ICharFrameRevolverBuilder $frameRevolverBuilder = null,
        ?IFrameCollectionRevolverBuilder $frameCollectionRevolverBuilder = null,
        ?IFrameCollectionFactory $frameCollectionFactory = null,
        ?IPatternFactory $patternFactory = null,
        ?IRevolverConfig $revolverConfig = null,
    ): ICharFrameRevolverFactory {
        return
            new CharFrameRevolverFactory(
                frameRevolverBuilder: $frameRevolverBuilder ?? $this->getCharFrameRevolverBuilderMock(),
                frameCollectionRevolverBuilder: $frameCollectionRevolverBuilder ?? $this->getFrameCollectionRevolverBuilderMock(
            ),
                patternFactory: $patternFactory ?? $this->getPatternFactoryMock(),
                frameCollectionFactory: $frameCollectionFactory ?? $this->getFrameCollectionFactoryMock(),
                revolverConfig: $revolverConfig ?? $this->getRevolverConfigMock(),
            );
    }

    private function getCharFrameRevolverBuilderMock(): MockObject&ICharFrameRevolverBuilder
    {
        return $this->createMock(ICharFrameRevolverBuilder::class);
    }

    protected function getFrameCollectionRevolverBuilderMock(): MockObject&IFrameCollectionRevolverBuilder
    {
        return $this->createMock(IFrameCollectionRevolverBuilder::class);
    }

    private function getPatternFactoryMock(): MockObject&IPatternFactory
    {
        return $this->createMock(IPatternFactory::class);
    }

    protected function getFrameCollectionFactoryMock(): MockObject&IFrameCollectionFactory
    {
        return $this->createMock(IFrameCollectionFactory::class);
    }

    private function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $interval = $this->getIntervalMock();
        $frames = $this->getTraversableMock();
        $tolerance = $this->getToleranceMock();
        $pattern = $this->getPatternMock();
        $pattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $pattern
            ->expects(self::once())
            ->method('getFrames')
            ->willReturn($frames)
        ;
        $palette = $this->getPaletteMock();

        $patternFactory = $this->getPatternFactoryMock();
        $patternFactory
            ->expects(self::once())
            ->method('create')
            ->with($palette)
            ->willReturn($pattern)
        ;
        $frameCollection = $this->getFrameCollectionMock();
        $frameCollectionFactory = $this->getFrameCollectionFactoryMock();
        $frameCollectionFactory
            ->expects(self::once())
            ->method('create')
            ->with($frames)
            ->willReturn($frameCollection)
        ;

        $frameCollectionRevolverBuilder = $this->getFrameCollectionRevolverBuilderMock();
        $frameCollectionRevolverBuilder
            ->expects(self::once())
            ->method('withFrames')
            ->with($frameCollection)
            ->willReturnSelf()
        ;
        $frameCollectionRevolverBuilder
            ->expects(self::once())
            ->method('withInterval')
            ->with($interval)
            ->willReturnSelf()
        ;
        $frameCollectionRevolverBuilder
            ->expects(self::once())
            ->method('withTolerance')
            ->with($tolerance)
            ->willReturnSelf()
        ;

        $frameRevolver = $this->getFrameCollectionRevolverMock();
        $frameCollectionRevolverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($frameRevolver)
        ;

        $revolverConfig = $this->getRevolverConfigMock();
        $revolverConfig
            ->expects(self::once())
            ->method('getTolerance')
            ->willReturn($tolerance)
        ;

        $styleRevolverFactory =
            $this->getTesteeInstance(
                frameCollectionRevolverBuilder: $frameCollectionRevolverBuilder,
                frameCollectionFactory: $frameCollectionFactory,
                patternFactory: $patternFactory,
                revolverConfig: $revolverConfig,
            );

        self::assertInstanceOf(CharFrameRevolverFactory::class, $styleRevolverFactory);

        self::assertSame(
            $frameRevolver,
            $styleRevolverFactory->create($palette),
        );
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    private function getPatternMock(): MockObject&IPattern
    {
        return $this->createMock(IPattern::class);
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    private function getFrameCollectionMock(): MockObject&IFrameCollection
    {
        return $this->createMock(IFrameCollection::class);
    }

    private function getFrameCollectionRevolverMock(): MockObject&IFrameCollectionRevolver
    {
        return $this->createMock(IFrameCollectionRevolver::class);
    }

    #[Test]
    public function canCreateFromInfinitePattern(): void
    {
        $interval = $this->getIntervalMock();
        $frames = $this->getTraversableMock();
        $tolerance = $this->getToleranceMock();
        $pattern = $this->getInfinitePatternMock();
        $pattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $pattern
            ->expects(self::once())
            ->method('getFrames')
            ->willReturn($frames)
        ;
        $palette = $this->getPaletteMock();

        $patternFactory = $this->getPatternFactoryMock();
        $patternFactory
            ->expects(self::once())
            ->method('create')
            ->with($palette)
            ->willReturn($pattern)
        ;
        $frameCollectionFactory = $this->getFrameCollectionFactoryMock();
        $frameCollectionFactory
            ->expects(self::never())
            ->method('create')
        ;

        $frameRevolverBuilder = $this->getCharFrameRevolverBuilderMock();
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withFrames')
            ->with($frames)
            ->willReturnSelf()
        ;
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withInterval')
            ->with($interval)
            ->willReturnSelf()
        ;
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withTolerance')
            ->with($tolerance)
            ->willReturnSelf()
        ;

        $frameRevolver = $this->getFrameRevolverMock();
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($frameRevolver)
        ;

        $revolverConfig = $this->getRevolverConfigMock();
        $revolverConfig
            ->expects(self::once())
            ->method('getTolerance')
            ->willReturn($tolerance)
        ;

        $styleRevolverFactory =
            $this->getTesteeInstance(
                frameRevolverBuilder: $frameRevolverBuilder,
                frameCollectionFactory: $frameCollectionFactory,
                patternFactory: $patternFactory,
                revolverConfig: $revolverConfig,
            );

        self::assertInstanceOf(CharFrameRevolverFactory::class, $styleRevolverFactory);

        self::assertSame(
            $frameRevolver,
            $styleRevolverFactory->create($palette),
        );
    }

    private function getInfinitePatternMock(): MockObject&IInfinitePattern
    {
        return $this->createMock(IInfinitePattern::class);
    }

    private function getFrameRevolverMock(): MockObject&IFrameRevolver
    {
        return $this->createMock(IFrameRevolver::class);
    }
}
