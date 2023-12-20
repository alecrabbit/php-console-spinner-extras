<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory\Contract;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Extras\Contract\IAnsiColorParser;

interface IAnsiColorParserFactory
{
    public function create(StylingMethodMode $styleMode): IAnsiColorParser;
}
