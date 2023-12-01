<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Root\Contract;

use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Root\Contract\IFacade as ICoreFacade;

interface IFacade extends ICoreFacade
{
    public static function getWidgetFactory(): IWidgetFactory;
}
