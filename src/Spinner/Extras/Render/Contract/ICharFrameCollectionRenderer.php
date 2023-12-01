<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Render\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgument;

interface ICharFrameCollectionRenderer
{
    /**
     * @throws InvalidArgument
     */
    public function render(IPattern $pattern): IFrameCollection;
}
