<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

final readonly class BrailleIndexConverter implements IIndexConverter
{
    private const START_CODEPOINT = 0x2800;
    private const A = [
        0b10000000 => 0b00000001, // '⠁' // #0 -> #7
        0b01000000 => 0b00000010, // '⠂' // #1 -> #6
        0b00100000 => 0b00000100, // '⠄' // #2 -> #5
        0b00001000 => 0b00001000, // '⠈' // #4 -> #4
        0b00000100 => 0b00010000, // '⠐' // #5 -> #3
        0b00000010 => 0b00100000, // '⠠' // #6 -> #2
        0b00010000 => 0b01000000, // '⡀' // #3 -> #1
        0b00000001 => 0b10000000, // '⢀' // #7 -> #0
    ];

    private array $table;

    public function __construct()
    {
        $this->table = $this->generateTable();
    }

    private function generateTable(): array
    {
        $table = [];
        for ($i = 0; $i < 256; $i++) {
            $table[$i] = $this->calculateEntry($i);
        }
        return $table;
    }

    private function calculateEntry(int $input): int
    {
        $output = 0;
        foreach (self::A as $key => $value) {
            if ($input & $key) {
                $output |= $value;
            }
        }
        return $output;
    }

    public function convert(int $input): int
    {
        return $this->table[$input];
    }

    public function getStartCodepoint(): int
    {
        return self::START_CODEPOINT;
    }
}
