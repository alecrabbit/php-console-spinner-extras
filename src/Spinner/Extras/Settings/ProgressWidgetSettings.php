<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Extras\Settings\A\AMultiWidgetSettings;
use AlecRabbit\Spinner\Extras\Settings\Contract\IProgressWidgetSettings;
use Traversable;

final readonly class ProgressWidgetSettings extends AMultiWidgetSettings implements IProgressWidgetSettings
{
    public function getIdentifier(): string
    {
        return IProgressWidgetSettings::class;
    }
}
