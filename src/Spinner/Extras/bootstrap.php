<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
//use AlecRabbit\Spinner\Core\Factory\Contract\ITerminalProbeFactory;
//use AlecRabbit\Spinner\Core\Factory\TerminalProbeFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\HexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Terminal\SymfonyTerminalProbe;

// @codeCoverageIgnoreStart
$definitions = DefinitionRegistry::getInstance();

$definitions->bind(
    new \AlecRabbit\Spinner\Container\ServiceDefinition(
        IHexColorToAnsiCodeConverterFactory::class,
        HexColorToAnsiCodeConverterFactory::class,
    )
);
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
