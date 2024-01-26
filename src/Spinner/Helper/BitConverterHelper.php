<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

final class BitConverterHelper implements IBitConverterHelper
{
    private const A = [
    //    01234567      01234567
    //  0b00000000 => 0b00000000, // ' '
        0b10000000 => 0b00000001, // '⠁' // #7 become #0
        0b01000000 => 0b00000010, // '⠂' // #6 become #1
        0b00100000 => 0b00000100, // '⠄' // #5 become #2
        0b00001000 => 0b00001000, // '⠈' // #4 become #4
        0b00000100 => 0b00010000, // '⠐' // #3 become #5
        0b00000010 => 0b00100000, // '⠠' // #2 become #6
        0b00010000 => 0b01000000, // '⡀' // #1 become #3
        0b00000001 => 0b10000000, // '⢀' // #0 become #7
    ];

    public function convert(int $input): int
    {
        $output= 0;
        foreach (self::A as $key => $value) {
            if ($input & $key) {
                $output |= $value;
            }
        }
        return $output;
    }
}
