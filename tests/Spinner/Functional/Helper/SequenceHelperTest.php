<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Helper;


use AlecRabbit\Spinner\Helper\ISequenceHelper;
use AlecRabbit\Spinner\Helper\SequenceHelper;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SequenceHelperTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $helper = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceHelper::class, $helper);
    }

    private function getTesteeInstance():ISequenceHelper
    {
        return new SequenceHelper();
    }
}
