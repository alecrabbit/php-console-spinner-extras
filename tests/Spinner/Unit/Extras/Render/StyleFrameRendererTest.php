<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras\Render;

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
        ?IStyleRenderer $renderer = null,
    ): IStyleFrameRenderer {
        return new StyleFrameRenderer(
            renderer: $renderer ?? $this->getStyleRendererMock(),
        );
    }

    private function getStyleRendererMock(): MockObject&IStyleRenderer
    {
        return $this->createMock(IStyleRenderer::class);
    }

//    #[Test]
//    public function canRender(): void
//    {
////        $style = $this->getStyleMock();
////        $style
////            ->expects(self::once())
////            ->method('isEmpty')
////            ->willReturn(false)
////        ;
////        $style
////            ->expects(self::never())
////            ->method('getFormat')
////        ;
////        $style
////            ->expects(self::never())
////            ->method('getWidth')
////        ;
////        $converter = $this->getStyleToAnsiStringConverterMock();
////        $converter
////            ->expects(self::once())
////            ->method('convert')
////            ->with($style)
////            ->willReturn('%s ')
////        ;
////        $styleFrameRenderer = $this->getTesteeInstance(
////            renderer: $converter,
////        );
////        self::assertInstanceOf(StyleFrameRenderer::class, $styleFrameRenderer);
////        self::assertEquals(
////            '%s ',
////            $styleFrameRenderer->render($style),
////        );
//    }

    protected function getStyleToAnsiStringConverterMock(): MockObject&IStyleToAnsiStringConverter
    {
        return $this->createMock(IStyleToAnsiStringConverter::class);
    }

    protected function getStyleMock(): MockObject&IStyle
    {
        return $this->createMock(IStyle::class);
    }
}
