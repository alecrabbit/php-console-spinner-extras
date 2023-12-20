<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Extras\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Extras\Pattern\Contract\IInfinitePattern;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Revolver\Builder\Contract\IStyleFrameRevolverBuilder;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class StyleFrameRevolverFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $styleRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRevolverFactory::class, $styleRevolverFactory);
    }

    public function getTesteeInstance(
        ?IStyleFrameRevolverBuilder $frameRevolverBuilder = null,
        ?IFrameCollectionRevolverBuilder $frameCollectionRevolverBuilder = null,
        ?IFrameCollectionFactory $frameCollectionFactory = null,
        ?IRevolverConfig $revolverConfig = null,
        ?IStyleRenderer $styleRenderer = null,
    ): IStyleFrameRevolverFactory {
        return
            new StyleFrameRevolverFactory(
                frameRevolverBuilder: $frameRevolverBuilder ?? $this->getStyleFrameRevolverBuilderMock(),
                frameCollectionRevolverBuilder: $frameCollectionRevolverBuilder ?? $this->getFrameCollectionRevolverBuilderMock(
            ),
                frameCollectionFactory: $frameCollectionFactory ?? $this->getFrameCollectionFactoryMock(),
                revolverConfig: $revolverConfig ?? $this->getRevolverConfigMock(),
                styleRenderer: $styleRenderer ?? $this->getStyleRendererMock(),
            );
    }

    protected function getStyleFrameRevolverBuilderMock(): MockObject&IStyleFrameRevolverBuilder
    {
        return $this->createMock(IStyleFrameRevolverBuilder::class);
    }

    protected function getFrameCollectionRevolverBuilderMock(): MockObject&IFrameCollectionRevolverBuilder
    {
        return $this->createMock(IFrameCollectionRevolverBuilder::class);
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
                revolverConfig: $revolverConfig,
            );

        self::assertInstanceOf(StyleFrameRevolverFactory::class, $styleRevolverFactory);

        self::assertSame(
            $frameRevolver,
            $styleRevolverFactory->create($pattern),
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
        $styleRenderer = $this->getStyleRendererMock();

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
        $frameCollectionFactory = $this->getFrameCollectionFactoryMock();
        $frameCollectionFactory
            ->expects(self::never())
            ->method('create')
        ;

        $frameRevolverBuilder = $this->getStyleFrameRevolverBuilderMock();
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
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withStyleRenderer')
            ->with($styleRenderer)
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
                revolverConfig: $revolverConfig,
                styleRenderer: $styleRenderer,
            );

        self::assertInstanceOf(StyleFrameRevolverFactory::class, $styleRevolverFactory);

        self::assertSame(
            $frameRevolver,
            $styleRevolverFactory->create($pattern),
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

    private function getStyleRendererMock(): MockObject&IStyleRenderer
    {
        return $this->createMock(IStyleRenderer::class);
    }
}
