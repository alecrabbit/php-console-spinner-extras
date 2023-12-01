<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Pattern;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Pattern\A\AStylePattern;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use Traversable;

/** @psalm-suppress UnusedClass */
final class CustomStylePattern extends AStylePattern
{
    public function __construct(
        protected array $pattern,
        ?int $interval = null,
        bool $reversed = false,
    ) {
        self::assertPattern($pattern);
        parent::__construct(
            interval: $interval,
            reversed: $reversed,
        );
    }

    /**
     * @throws InvalidArgument
     */
    private static function assertPattern(array $pattern): void
    {
        if (empty($pattern)) {
            throw new InvalidArgument('Pattern is empty.');
        }
        if (!array_key_exists(StylingMethodOption::ANSI4->value, $pattern)) {
            throw new InvalidArgument('Pattern does not contain ANSI4 key.');
        }
        if (!array_key_exists(StylingMethodOption::ANSI8->value, $pattern)) {
            throw new InvalidArgument('Pattern does not contain ANSI8 key.');
        }
        if (!array_key_exists(StylingMethodOption::ANSI24->value, $pattern)) {
            throw new InvalidArgument('Pattern does not contain ANSI24 key.');
        }
        self::assertPatternSection($pattern[StylingMethodOption::ANSI4->value]);
        self::assertPatternSection($pattern[StylingMethodOption::ANSI8->value]);
        self::assertPatternSection($pattern[StylingMethodOption::ANSI24->value]);
//        match (true) {
//            empty($pattern) => throw new InvalidArgument('Pattern is empty.'),
//            !array_key_exists(StylingMethodOption::ANSI4->value, $pattern)
//            =>
//            throw new InvalidArgument('Pattern does not contain ANSI4 key.'),
//            !array_key_exists(StylingMethodOption::ANSI8->value, $pattern)
//            =>
//            throw new InvalidArgument('Pattern does not contain ANSI8 key.'),
//            !array_key_exists(StylingMethodOption::ANSI24->value, $pattern)
//            =>
//            throw new InvalidArgument('Pattern does not contain ANSI24 key.'),
//        };
    }

    private static function assertPatternSection(mixed $value): void
    {
    }

    public function getEntries(StylingMethodOption $styleMode = StylingMethodOption::ANSI8): Traversable
    {
        yield from $this->pattern[$styleMode->value];
    }
}
