<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras\Render;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleFrameRenderer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleFrameRendererTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $styleFrameRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
    }

    public function getTesteeInstance(
        ?IStyleFrameFactory $frameFactory = null,
        ?IStyleRenderer $styleRenderer = null,
        ?StylingMethodOption $styleMode = null,
    ): IStyleFrameRenderer {
        return new StyleFrameRenderer(
            frameFactory: $frameFactory ?? $this->getStyleFrameFactoryMock(),
            styleRenderer: $styleRenderer ?? $this->getStyleRendererMock(),
            styleMode: $styleMode ?? StylingMethodOption::NONE,
        );
    }

    #[Test]
    public function canRender(): void
    {
        $frame = $this->getFrameMock();
        $rendered = 'rendered';
        $frameFactory = $this->getStyleFrameFactoryMock();
        $frameFactory
            ->expects(self::once())
            ->method('create')
            ->with($rendered, 0)
            ->willReturn($frame)
        ;
        $styleRenderer = $this->getStyleRendererMock();
        $styleRenderer
            ->expects(self::once())
            ->method('render')
            ->willReturn($rendered)
        ;
        $styleFrameRenderer = $this->getTesteeInstance(
            frameFactory: $frameFactory,
            styleRenderer: $styleRenderer,
            styleMode: StylingMethodOption::ANSI8,
        );
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(false)
        ;
        $style
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn(0)
        ;

        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
        self::assertSame($frame, $styleFrameRenderer->render($style));
    }

    #[Test]
    public function canRenderIfStyleIsEmpty(): void
    {
        $frame = $this->getFrameMock();
        $format = ' %s ';

        $frameFactory = $this->getStyleFrameFactoryMock();
        $width = 2;
        $frameFactory
            ->expects(self::once())
            ->method('create')
            ->with($format, $width)
            ->willReturn($frame)
        ;
        $styleRenderer = $this->getStyleRendererMock();
        $styleRenderer
            ->expects(self::never())
            ->method('render')
        ;
        $styleFrameRenderer = $this->getTesteeInstance(
            frameFactory: $frameFactory,
            styleRenderer: $styleRenderer,
            styleMode: StylingMethodOption::ANSI8,
        );
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(true)
        ;
        $style
            ->expects(self::once())
            ->method('getFormat')
            ->willReturn($format)
        ;
        $style
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn($width)
        ;

        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
        self::assertSame($frame, $styleFrameRenderer->render($style));
    }

    #[Test]
    public function canRenderIfStyleModeIsNone(): void
    {
        $frameFactory = $this->getStyleFrameFactoryMock();
        $frame = $this->getFrameMock();
        $frameFactory
            ->expects(self::once())
            ->method('create')
            ->with('%s', 0)
            ->willReturn($frame)
        ;
        $styleFrameRenderer = $this->getTesteeInstance(
            frameFactory: $frameFactory,
            styleMode: StylingMethodOption::NONE
        );

        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
        self::assertSame($frame, $styleFrameRenderer->render($this->getStyleMock()));
    }
}
