<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Spinner\Unit\Extras;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Extras\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Extras\Factory\Contract\ICharFrameFactory;
use AlecRabbit\Spinner\Extras\Render\CharFrameRenderer;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @deprecated
 */
final class CharFrameRendererTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $charFrameRenderer = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameRenderer::class, $charFrameRenderer);
    }

    public function getTesteeInstance(
        ?ICharFrameFactory $frameFactory = null,
    ): ICharFrameRenderer {
        return new CharFrameRenderer(
            frameFactory: $frameFactory ?? $this->getCharFrameFactoryMock(),
        );
    }

    private function getCharFrameFactoryMock(): MockObject&ICharFrameFactory
    {
        return $this->createMock(ICharFrameFactory::class);
    }

    #[Test]
    public function canRender(): void
    {
        $str = 'test';

        $frameFactory = $this->getCharFrameFactoryMock();
        $frameMock = $this->getSequenceFrameMock();
        $frameFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($frameMock)
        ;

        $charFrameRenderer = $this->getTesteeInstance(frameFactory: $frameFactory);
        self::assertSame($frameMock, $charFrameRenderer->render($str));
    }

    protected function getSequenceFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }
}
