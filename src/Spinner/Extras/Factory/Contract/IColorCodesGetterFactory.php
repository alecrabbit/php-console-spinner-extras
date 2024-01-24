<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Extras\Color\Contract\IColorCodesGetter;

interface IColorCodesGetterFactory
{
    public function create(): IColorCodesGetter;
}
