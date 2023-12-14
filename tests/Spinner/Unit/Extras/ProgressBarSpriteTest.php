<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Extras;

use AlecRabbit\Spinner\Extras\ProgressBarSprite;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ProgressBarSpriteTest extends TestCase
{
    #[Test]
    public function canCreateDefault(): void
    {
        $instance = new ProgressBarSprite();
        self::assertSame('', $instance->getOpen());
        self::assertSame('', $instance->getClose());
        self::assertSame('█', $instance->getDone());
        self::assertSame('▓', $instance->getCursor());
        self::assertSame('░', $instance->getEmpty());
    }

    #[Test]
    public function canCreate(): void
    {
        $empty = 'e';
        $done = 'd';
        $cursor = 'c';
        $open = 'o';
        $close = 'f';

        $instance = new ProgressBarSprite(
            empty: $empty,
            done: $done,
            cursor: $cursor,
            open: $open,
            close: $close,
        );

        self::assertSame($empty, $instance->getEmpty());
        self::assertSame($done, $instance->getDone());
        self::assertSame($cursor, $instance->getCursor());
        self::assertSame($open, $instance->getOpen());
        self::assertSame($close, $instance->getClose());
    }
}
