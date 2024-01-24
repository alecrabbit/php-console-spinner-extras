<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;

interface IStyleRendererFactory
{
    public function create(): IStyleRenderer;
}
