<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras\Render;

use AlecRabbit\Spinner\Extras\Contract\IStyleFrame;
use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleFrameRenderer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StyleFrameRendererTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $styleFrameRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
    }

    public function getTesteeInstance(
        ?IStyleRenderer $styleRenderer = null,
    ): IStyleFrameRenderer {
        return new StyleFrameRenderer(
            renderer: $styleRenderer ?? $this->getStyleRendererMock(),
        );
    }

    private function getStyleRendererMock(): MockObject&IStyleRenderer
    {
        return $this->createMock(IStyleRenderer::class);
    }

    #[Test]
    public function canRender(): void
    {
        $sequence = '%s ';
        $width = 1;

        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn($width)
        ;

        $styleFrame = $this->getStyleFrameMock();
        $styleFrame
            ->expects(self::once())
            ->method('getStyle')
            ->willReturn($style)
        ;

        $styleRenderer = $this->getStyleRendererMock();
        $styleRenderer
            ->expects(self::once())
            ->method('render')
            ->with($style)
            ->willReturn($sequence)
        ;

        $styleFrameRenderer = $this->getTesteeInstance(
            styleRenderer: $styleRenderer,
        );

        $frame = $styleFrameRenderer->render($styleFrame);

        self::assertSame($sequence, $frame->getSequence());
        self::assertSame($width, $frame->getWidth());
    }

    protected function getStyleMock(): MockObject&IStyle
    {
        return $this->createMock(IStyle::class);
    }

    private function getStyleFrameMock(): MockObject&IStyleFrame
    {
        return $this->createMock(IStyleFrame::class);
    }

    protected function getStyleToAnsiStringConverterMock(): MockObject&IStyleToAnsiStringConverter
    {
        return $this->createMock(IStyleToAnsiStringConverter::class);
    }
}
