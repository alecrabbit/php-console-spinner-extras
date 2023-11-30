<?php

namespace AlecRabbit\Tests\Spinner\Disabled\Unit\Pattern;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Pattern\CustomStylePattern;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

/**
 * FIXME (2023-05-03 15:59) [Alec Rabbit]: Unfinished test, tested class purpose is not defined yet.
 */
final class CustomStylePatternTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(CustomStylePattern::class, $factory);
    }

    public function getTesteeInstance(
        ?array $pattern = null,
    ): IStylePattern {
        return new CustomStylePattern(
            pattern: $pattern ?? [
            StylingMethodOption::ANSI4->value => [
                'pattern' => new StyleFrame('%s', 0),
            ],
            StylingMethodOption::ANSI8->value => [
                'pattern' => new StyleFrame('%s', 0),
            ],
            StylingMethodOption::ANSI24->value => [
                'pattern' => new StyleFrame('%s', 0),
            ],
        ],
        );
    }

    #[Test]
    public function throwsIfPatternIsEmpty(): void
    {
        $exception = new InvalidArgument('Pattern is empty.');

        $test = function () {
            $this->getTesteeInstance(
                pattern: [],
            );
        };
        $this->wrapExceptionTest(
            $test,
            $exception,
        );
    }

    #[Test]
    public function throwsIfPatternIsDoesNotHaveAnsi4Key(): void
    {
        $exception = new InvalidArgument('Pattern does not contain ANSI4 key.');

        $test = function () {
            $this->getTesteeInstance(
                pattern: [
//                    StylingMethodOption::ANSI4->value => [],
                    StylingMethodOption::ANSI8->value => [],
                    StylingMethodOption::ANSI24->value => [],
                ],
            );
        };
        $this->wrapExceptionTest(
            $test,
            $exception,
        );
    }
}
