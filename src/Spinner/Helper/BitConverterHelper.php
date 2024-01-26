<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

final class BitConverterHelper implements IBitConverterHelper
{
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

    public function convert(int $input): int
    {
        $output = 0;
        foreach (self::A as $key => $value) {
            if ($input & $key) {
                $output |= $value;
            }
        }
        return $output;
    }
}
