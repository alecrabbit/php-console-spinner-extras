<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Root\A;

use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\ISpinnerSettings;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Extras\Contract\IExtrasSpinner;
use AlecRabbit\Spinner\Root\A\AFacade as ACoreFacade;

abstract class AFacade extends ACoreFacade
{
    public static function getWidgetFactory(): IWidgetFactory
    {
        return self::getContainer()->get(IWidgetFactory::class);
    }

    public static function createSpinner(?ISpinnerSettings $spinnerSettings = null): IExtrasSpinner
    {
        $spinner = parent::createSpinner($spinnerSettings);

        if ($spinner instanceof IExtrasSpinner) {
            return $spinner;
        }

        // @codeCoverageIgnoreStart
        throw new DomainException(
            sprintf(
                'Spinner is not an instance of %s',
                IExtrasSpinner::class
            ),
        );
        // @codeCoverageIgnoreEnd
    }
}
