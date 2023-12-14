<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Settings;

use AlecRabbit\Spinner\Extras\Settings\A\AMultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Settings\Contract\IMultiWidgetSettings;

final readonly class MultiWidgetSettings extends AMultiWidgetSettings
{
    public function getIdentifier(): string
    {
        return IMultiWidgetSettings::class;
    }
}
