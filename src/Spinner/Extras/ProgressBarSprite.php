<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Contract\IProgressBarSprite;

use function is_string;
use function mb_strlen;

/** @psalm-suppress UnusedClass */
final readonly class ProgressBarSprite implements IProgressBarSprite
{
    private string $empty;
    private string $done;
    private string $cursor;
    private string $open;
    private string $close;

    public function __construct(
        string $empty = '░',
        string $done = '█',
        string $cursor = '▓',
        string $open = '',
        string $close = '',
        ?string $sample = null,
    ) {
        if (is_string($sample)) {
            self::assertSample($sample);
            if (mb_strlen($sample) === 3) {
                [
                    $done,
                    $cursor,
                    $empty,
                ] = mb_str_split($sample);
            } else {
                [
                    $open,
                    $done,
                    $cursor,
                    $empty,
                    $close,
                ] = mb_str_split($sample);
            }
        }

        $this->empty = $empty;
        $this->done = $done;
        $this->cursor = $cursor;
        $this->open = $open;
        $this->close = $close;
    }

    private static function assertSample(?string $sample): void
    {
        $len = mb_strlen($sample);
        match ($len) {
            0 => throw new InvalidArgument('Sample cannot be empty.'),
            3, 5 => null,
            default => throw new InvalidArgument('Sample must be 3 or 5 characters long.'),
        };
    }

    public function getEmpty(): string
    {
        return $this->empty;
    }

    public function getDone(): string
    {
        return $this->done;
    }

    public function getCursor(): string
    {
        return $this->cursor;
    }

    public function getOpen(): string
    {
        return $this->open;
    }

    public function getClose(): string
    {
        return $this->close;
    }
}
