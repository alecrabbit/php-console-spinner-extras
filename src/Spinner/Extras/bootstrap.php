<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteTemplateFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\HexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Extras\Palette\Builder\Contract\IInfinitePaletteTemplateBuilder;
use AlecRabbit\Spinner\Extras\Palette\Builder\InfinitePaletteTemplateBuilder;
use AlecRabbit\Spinner\Extras\Palette\Factory\PaletteTemplateFactory;
use AlecRabbit\Spinner\Extras\Pattern\Factory\PatternFactory;
use AlecRabbit\Spinner\Extras\Revolver\Builder\FrameRevolverBuilder;
use AlecRabbit\Spinner\Extras\Widget\Builder\WidgetCompositeBuilder;
use AlecRabbit\Spinner\Extras\Widget\Contract\Builder\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Extras\Widget\Factory\WidgetCompositeFactory;

//use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalProbeFactory;
//use AlecRabbit\Spinner\Core\Factory\TerminalProbeFactory;

// @codeCoverageIgnoreStart
DefinitionRegistry::getInstance()
    ->bind(
        new ServiceDefinition(
            IHexColorToAnsiCodeConverterFactory::class,
            HexColorToAnsiCodeConverterFactory::class,
        ),
        new ServiceDefinition(
            IWidgetFactory::class,
            WidgetCompositeFactory::class,
        ),
        new ServiceDefinition(
            IWidgetCompositeBuilder::class,
            WidgetCompositeBuilder::class,
        ),
        new ServiceDefinition(
            IPaletteTemplateFactory::class,
            PaletteTemplateFactory::class,
        ),
        new ServiceDefinition(
            IInfinitePaletteTemplateBuilder::class,
            InfinitePaletteTemplateBuilder::class,
        ),
        new ServiceDefinition(
            IStyleFrameRevolverFactory::class,
            StyleFrameRevolverFactory::class,
        ),
        new ServiceDefinition(
            IFrameRevolverBuilder::class,
            FrameRevolverBuilder::class,
        ),
        new ServiceDefinition(
            IPatternFactory::class,
            PatternFactory::class,
        ),
    )
;

//$definitions->bind(
//    ITerminalProbeFactory::class,
//    static function (): ITerminalProbeFactory {
//        return new TerminalProbeFactory(
//            new ArrayObject([
//                SymfonyTerminalProbe::class,
//            ]),
//        );
//    },
//);
// @codeCoverageIgnoreEnd
