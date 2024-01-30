<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

final readonly class IndexToCodepointConverter implements IIndexToCodepointConverter
{
    private int $start;
    private int $max;

    public function __construct(
        private IIndexConverter $indexConverter = new BrailleIndexConverter(),
    ) {
        $this->start = $this->indexConverter->getStartCodepoint();
        $this->max = $this->indexConverter->getMax();
    }

    public function getCodepoint(int $index): int
    {
        $index = max(0, min($this->max, $index));

        return $this->start + $this->indexConverter->convert($index);
    }
}
