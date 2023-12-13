<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Settings\Contract;

use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Extras\Settings\A\AMultiWidgetSettings;
use Traversable;

interface IMultiWidgetSettings extends IWidgetSettings
{
    /**
     * @return Traversable<IWidgetSettings>
     */
    public function getAll(): Traversable;

    /**
     * @return Traversable<IWidgetSettings>
     */
    public function getOther(): Traversable;
}
