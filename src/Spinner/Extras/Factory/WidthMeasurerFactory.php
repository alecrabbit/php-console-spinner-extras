<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Extras\Contract\IWidthGetter;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\Factory\Contract\IWidthMeasurerFactory;
use AlecRabbit\Spinner\Extras\WidthMeasurer;

use function AlecRabbit\WCWidth\wcswidth;
use function mb_strlen;

final class WidthMeasurerFactory implements IWidthMeasurerFactory
{
    public function create(): IWidthMeasurer
    {
        return new WidthMeasurer(
            self::createWidthGetter()
        );
    }

    /**
     * @codeCoverageIgnore
     */
    private static function createWidthGetter(): IWidthGetter
    {
        if (function_exists('\AlecRabbit\WCWidth\wcswidth')) {
            return new class implements IWidthGetter {
                public function getWidth(string $string): int
                {
                    return wcswidth($string);
                }
            };
        }

        if (function_exists('\mb_strlen')) {
            return new class implements IWidthGetter {
                public function getWidth(string $string): int
                {
                    return mb_strlen($string);
                }
            };
        }

        return new class implements IWidthGetter {
            public function getWidth(string $string): int
            {
                return strlen($string);
            }
        };
    }
}
