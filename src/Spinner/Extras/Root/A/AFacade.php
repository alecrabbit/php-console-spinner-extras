<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Root\A;

use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Root\A\AFacade as ACoreFacade;

abstract class AFacade extends ACoreFacade
{
    public static function getWidgetFactory(): IWidgetFactory
    {
        return self::getContainer()->get(IWidgetFactory::class);
    }
}
