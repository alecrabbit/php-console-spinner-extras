<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleToAnsiStringConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\StyleRendererFactory;
use AlecRabbit\Spinner\Extras\Render\StyleRenderer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StyleRendererFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $styleRendererFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleRendererFactory::class, $styleRendererFactory);
    }

    public function getTesteeInstance(
        ?IStyleToAnsiStringConverterFactory $converterFactory = null,
    ): IStyleRendererFactory {
        return new StyleRendererFactory(
            converterFactory: $converterFactory ?? $this->getStyleToAnsiStringConverterFactoryMock(),
        );
    }

    private function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $converter = $this->getStyleToAnsiStringConverterMock();

        $converterFactory = $this->getStyleToAnsiStringConverterFactoryMock();
        $converterFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($converter)
        ;

        $styleRendererFactory = $this->getTesteeInstance(
            converterFactory: $converterFactory,
        );

        $renderer = $styleRendererFactory->create();
        self::assertInstanceOf(StyleRendererFactory::class, $styleRendererFactory);
        self::assertInstanceOf(StyleRenderer::class, $renderer);
        self::assertSame($converter, self::getPropertyValue('converter', $renderer));
    }
}
