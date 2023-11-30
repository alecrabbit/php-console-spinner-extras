<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color\A;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Color\Ansi4Color;
use AlecRabbit\Spinner\Extras\Color\Ansi8Color;
use AlecRabbit\Spinner\Extras\Color\Mixin\Ansi8ColorTableTrait;

abstract class AColorToAnsiCodeConverter
{
    use Ansi8ColorTableTrait;

    public function __construct(
        protected StylingMethodOption $styleMode,
    ) {
        self::assert($this);
    }

    protected static function assert(self $obj): void
    {
        if ($obj->styleMode === StylingMethodOption::NONE) {
            throw new InvalidArgument(
                sprintf(
                    'Unsupported style mode "%s".',
                    $obj->styleMode->name,
                )
            );
        }
    }

    /**
     * @throws InvalidArgument
     */
    protected function normalize(string $color): string
    {
        $color = strtolower($color);

        $color = str_replace('#', '', $color);

        if (strlen($color) === 3) {
            $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
        }

        $this->assertColor($color);

        return '#' . $color;
    }

    /**
     * @throws InvalidArgument
     */
    private function assertColor(array|string $color): void
    {
        if ($color === '') {
            throw new InvalidArgument('Empty color string.');
        }

        if (strlen($color) !== 6) {
            throw new InvalidArgument(sprintf('Invalid color: "#%s".', $color));
        }
    }

    /**
     * @throws InvalidArgument
     */
    protected function convert8(string $color): string
    {
        $index = Ansi8Color::getIndex($color);

        if ($index) {
            return '8;5;' . $index;
        }

        return $this->convertHexColorToAnsiColorCode($color);
    }

    abstract protected function convertHexColorToAnsiColorCode(string $hexColor): string;

    /**
     * @throws InvalidArgument
     */
    protected function convert4(string $color): string
    {
        $index = Ansi4Color::getIndex($color);

        if ($index !== null) {
            return (string)$index;
        }

        return $this->convertHexColorToAnsiColorCode($color);
    }

    protected function toInt(string $color): int
    {
        return (int)hexdec(str_replace('#', '', $color));
    }
}
