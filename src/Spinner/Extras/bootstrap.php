<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\HexColorToAnsiCodeConverterFactory;
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
