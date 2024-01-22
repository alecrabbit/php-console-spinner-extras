<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;
use AlecRabbit\Spinner\Extras\Contract\IBrightAnsiCode;
use AlecRabbit\Spinner\Extras\Contract\IStyleToAnsiStringConverter;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptionsParser;

final class StyleToAnsiStringConverter implements IStyleToAnsiStringConverter
{
    private const SET = 'set';
    private const UNSET = 'unset';

    public function __construct(
        protected IAnsiColorParser $colorParser,
        protected IStyleOptionsParser $optionsParser,
    ) {
    }

    public function convert(IStyle $style): string
    {
        if ($style->isEmpty()) {
            return $style->getFormat();
        }

        return $this->doConvert($style);
    }

    private function doConvert(IStyle $style): string
    {
        $fg = $this->fg($style);
        $bg = $this->bg($style);

        $options =
            $style->hasOptions()
                ? $this->optionsParser->parseOptions($style->getOptions())
                : [];

        return
            $this->set($fg, $bg, $options)
            . $style->getFormat()
            . $this->unset($fg, $bg, $options);
    }

    private function fg(IStyle $style): string
    {
        $code = $this->colorParser->parseColor($style->getFgColor());

        $codePrefix = $code instanceof IBrightAnsiCode ? '9' : '3';
        return $code->isEmpty() ? '' : $codePrefix . $code->toString();
    }

    private function bg(IStyle $style): string
    {
        $code = $this->colorParser->parseColor($style->getBgColor());
        
        $codePrefix = $code instanceof IBrightAnsiCode ? '10' : '4';
        return $code->isEmpty() ? '' : $codePrefix . $code->toString();
    }

    private function set(string $fg, string $bg, iterable $options = []): string
    {
        $codes = [];
        if ($fg !== '') {
            $codes[] = $fg;
        }
        if ($bg !== '') {
            $codes[] = $bg;
        }
        foreach ($options as $option) {
            $codes[] = $option[self::SET];
        }
        if ($codes === []) {
            return '';
        }

        return $this->unwrap($codes);
    }

    private function unwrap(array $codes): string
    {
        return sprintf("\033[%sm", implode(';', array_unique($codes)));
    }

    public function unset(string $fg, string $bg, iterable $options = []): string
    {
        $codes = [];
        if ($fg !== '') {
            $codes[] = 39;
        }
        if ($bg !== '') {
            $codes[] = 49;
        }
        foreach ($options as $option) {
            $codes[] = $option[self::UNSET];
        }
        if ($codes === []) {
            return '';
        }

        return $this->unwrap($codes);
    }
}
