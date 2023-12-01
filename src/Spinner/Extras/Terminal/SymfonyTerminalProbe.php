<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Terminal;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;
use Symfony\Component\Console\Output\AnsiColorMode;
use Symfony\Component\Console\Terminal;

use function class_exists;

/**
 * @codeCoverageIgnore
 */
final class SymfonyTerminalProbe extends ATerminalProbe
{
    public function isAvailable(): bool
    {
        return class_exists(Terminal::class);
    }

    public function getWidth(): int
    {
        return (new Terminal())->getWidth();
    }

    public function getStylingMethodOption(): StylingMethodOption
    {
        return match (Terminal::getColorMode()) {
            AnsiColorMode::Ansi24 => StylingMethodOption::ANSI24,
            AnsiColorMode::Ansi8 => StylingMethodOption::ANSI8,
            AnsiColorMode::Ansi4 => StylingMethodOption::ANSI4,
        };
    }

    public function getOutputStream()
    {
        return STDERR;
    }
}
