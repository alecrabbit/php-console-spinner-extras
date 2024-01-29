<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

final readonly class SequenceHelper implements ISequenceHelper
{
    private const ENCODING = 'UTF-8';

    private int $start;

    public function __construct(
        private IIndexConverter $converter = new BrailleIndexConverter(),
        private string $encoding = self::ENCODING,
    ) {
        $this->start = $this->converter->getStartCodepoint();
    }

    public function get(int $input): string
    {
        return $this->getSymbol($this->getCodepoint($input));
    }

    private function getSymbol(int $codepoint): string
    {
        return mb_chr($codepoint, $this->encoding);
    }

    public function getCodepoint(int $input): int
    {
        $input = max(0, min(255, $input));

        return $this->start + $this->converter->convert($input);
    }
}
