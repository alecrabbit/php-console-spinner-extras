<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

final readonly class SequenceHelper implements ISequenceHelper
{
    private const ENCODING = 'UTF-8';

    public function __construct(
        private IBitConverterHelper $bitConverterHelper = new BitConverterHelper(),
    ) {
    }

    public function get(int $input): string
    {
        $input = max(0, min(255, $input));

        return $this->getBraille($this->bitConverterHelper->convert($input));
    }

    private function getBraille(int $input): string
    {
        return mb_chr(0x2800 + $input, self::ENCODING);
    }
}
