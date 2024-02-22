<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Render;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IStyleFrame;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleFrameTransformer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StyleFrameTransformerTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $transformer = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameTransformer::class, $transformer);
    }

    public function getTesteeInstance(
        ?IStyleFrameRenderer $styleFrameRenderer = null,
    ): IStyleFrameTransformer {
        return
            new StyleFrameTransformer(
                styleFrameRenderer: $styleFrameRenderer ?? $this->getStyleFrameRendererMock(),
            );
    }

    private function getStyleFrameRendererMock(): MockObject&IStyleFrameRenderer
    {
        return $this->createMock(IStyleFrameRenderer::class);
    }

    #[Test]
    public function passesFrameOfTargetTypeUnchanged(): void
    {
        $frame = $this->getStyleSequenceFrameMock();

        $transformer = $this->getTesteeInstance();

        self::assertSame($frame, $transformer->transform($frame));
    }

    private function getStyleSequenceFrameMock(): MockObject&IStyleSequenceFrame
    {
        return $this->createMock(IStyleSequenceFrame::class);
    }

    #[Test]
    public function transformsStyleFrameToStyleSequenceFrame(): void
    {
        $input = $this->getStyleFrameMock();
        $frame = $this->getStyleSequenceFrameMock();

        $styleFrameRenderer = $this->getStyleFrameRendererMock();
        $styleFrameRenderer
            ->expects(self::once())
            ->method('render')
            ->with($input)
            ->willReturn($frame)
        ;

        $transformer = $this->getTesteeInstance(
            styleFrameRenderer: $styleFrameRenderer,
        );

        self::assertSame($frame, $transformer->transform($input));
    }

    private function getStyleFrameMock(): MockObject&IStyleFrame
    {
        return $this->createMock(IStyleFrame::class);
    }

    #[Test]
    public function throwsIfFrameTypeIsNonTransformable(): void
    {
        $frame = $this->getFrameMock();

        $transformer = $this->getTesteeInstance();

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Non-transformable frame type "%s".',
                get_class($frame),
            )
        );

        $transformer->transform($frame);
    }

    private function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }
}
