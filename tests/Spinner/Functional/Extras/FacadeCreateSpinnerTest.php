<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras;

use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Builder\SpinnerBuilder;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Extras\Contract\IExtrasSpinner;
use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Tests\TestCase\ContainerModifyingTestCase;
use PHPUnit\Framework\Attributes\Test;

final class FacadeCreateSpinnerTest extends ContainerModifyingTestCase
{
    protected static function setTestContainer(): void
    {
        self::setContainer(
            self::modifyContainer(
                [
                    ISpinnerBuilder::class => SpinnerBuilder::class,
                ]
            )
        );
    }

    #[Test]
    public function canCreateSpinner(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(
            sprintf(
                'Spinner is not an instance of %s',
                IExtrasSpinner::class
            )
        );

        $spinner = Facade::createSpinner();

        self::fail('Exception was not thrown.');
    }
}
