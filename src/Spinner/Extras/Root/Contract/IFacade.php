<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Root\Contract;

use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Extras\Contract\IExtrasSpinner;
use AlecRabbit\Spinner\Root\Contract\IFacade as ICoreFacade;

interface IFacade extends ICoreFacade
{
    public static function getWidgetFactory(): IWidgetFactory;

    public static function createSpinner(?ISpinnerSettings $spinnerSettings = null): IExtrasSpinner;
}
