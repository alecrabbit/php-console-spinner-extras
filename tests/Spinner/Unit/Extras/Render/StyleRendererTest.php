<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras\Render;

use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleRenderer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleRendererTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $styleFrameRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleRenderer::class, $styleFrameRenderer);
    }

    public function getTesteeInstance(
        ?IStyleToAnsiStringConverter $converter = null,
    ): IStyleRenderer {
        return new StyleRenderer(
            converter: $converter ?? $this->getStyleToAnsiStringConverterMock(),
        );
    }

    #[Test]
    public function canRender(): void
    {
        $style = $this->getStyleMock();
        $style
            ->expects(self::once())
            ->method('isEmpty')
            ->willReturn(false)
        ;
        $style
            ->expects(self::never())
            ->method('getFormat')
        ;
        $style
            ->expects(self::never())
            ->method('getWidth')
        ;
        $converter = $this->getStyleToAnsiStringConverterMock();
        $converter
            ->expects(self::once())
            ->method('convert')
            ->with($style)
            ->willReturn('%s ')
        ;
        $styleFrameRenderer = $this->getTesteeInstance(
            converter: $converter,
        );
        self::assertInstanceOf(StyleRenderer::class, $styleFrameRenderer);
        self::assertEquals(
            '%s ',
            $styleFrameRenderer->render($style),
        );
    }

// // FIXME (2023-12-20 17:12) [Alec Rabbit]: add test for style is empty
//    #[Test]
//    public function throwsIfStyleIsEmpty(): void
//    {
//        $exceptionClass = InvalidArgument::class;
//        $exceptionMessage = 'Style is empty.';
//
//        $test = function (): void {
//            $style = $this->getStyleMock();
//            $style
//                ->expects(self::once())
//                ->method('isEmpty')
//                ->willReturn(true)
//            ;
//            $this->getTesteeInstance()->render($style, StylingMethodOption::ANSI8);
//        };
//
//        $this->wrapExceptionTest(
//            test: $test,
//            exception: $exceptionClass,
//            message: $exceptionMessage,
//        );
//    }
}
