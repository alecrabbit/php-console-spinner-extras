<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Disabled\Unit\Factory;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\StyleFrameRendererFactory;
use AlecRabbit\Spinner\Extras\Render\StyleFrameRenderer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleFrameRendererFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $styleFrameRendererFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRendererFactory::class, $styleFrameRendererFactory);
    }

    public function getTesteeInstance(
        ?IStyleFrameFactory $frameFactory = null,
        ?IStyleRendererFactory $styleRendererFactory = null,
        ?StylingMethodOption $styleMode = null,
    ): IStyleFrameRendererFactory {
        return new StyleFrameRendererFactory(
            frameFactory: $frameFactory ?? $this->getStyleFrameFactoryMock(),
            styleRendererFactory: $styleRendererFactory ?? $this->getStyleRendererFactoryMock(),
            styleMode: $styleMode ?? StylingMethodOption::ANSI4,
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $styleMode = StylingMethodOption::ANSI4; // lowest
        $frameFactory = $this->getStyleFrameFactoryMock();
        $styleRenderer = $this->getStyleRendererMock();

        $styleRendererFactory = $this->getStyleRendererFactoryMock();
        $styleRendererFactory
            ->expects(self::once())
            ->method('create')
            ->with($styleMode)
            ->willReturn($styleRenderer)
        ;

        $styleFrameRendererFactory = $this->getTesteeInstance(
            frameFactory: $frameFactory,
            styleRendererFactory: $styleRendererFactory,
            styleMode: StylingMethodOption::ANSI24 // to use lowest
        );

        $renderer = $styleFrameRendererFactory->create($styleMode);
        self::assertInstanceOf(StyleFrameRendererFactory::class, $styleFrameRendererFactory);
        self::assertInstanceOf(StyleFrameRenderer::class, $renderer);

        self::assertSame($frameFactory, self::getPropertyValue('frameFactory', $renderer));
        self::assertSame($styleRenderer, self::getPropertyValue('styleRenderer', $renderer));
        self::assertSame($styleMode, self::getPropertyValue('styleMode', $renderer));
    }
}
