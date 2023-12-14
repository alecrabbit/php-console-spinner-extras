<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Extras;

use AlecRabbit\Spinner\Extras\Facade;
use AlecRabbit\Spinner\Extras\Widget\Factory\WidgetCompositeFactory;
use AlecRabbit\Tests\TestCase\FacadeAwareTestCase;
use PHPUnit\Framework\Attributes\Test;

final class FacadeTest extends FacadeAwareTestCase
{
    #[Test]
    public function canGetWidgetFactory(): void
    {
        $widgetFactory = Facade::getWidgetFactory();

        self::assertInstanceOf(WidgetCompositeFactory::class, $widgetFactory);
    }
}
