<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Palette\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Palette\Builder\Contract\IInfinitePaletteTemplateBuilder;
use AlecRabbit\Spinner\Extras\Palette\InfinitePaletteTemplate;
use Traversable;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class InfinitePaletteTemplateBuilder implements IInfinitePaletteTemplateBuilder
{
    /**
     * @var Traversable<IFrame>|null
     */
    private ?Traversable $entries = null;
    private ?IPaletteOptions $options = null;

    public function build(): IPaletteTemplate
    {
        $this->validate();
        return new InfinitePaletteTemplate(
            entries: $this->entries,
            options: $this->options,
        );
    }

    /**
     * @throws InvalidArgument
     */
    private function validate(): void
    {
        match (true) {
            $this->entries === null => throw new InvalidArgument('Entries are not set.'),
            $this->options === null => throw new InvalidArgument('Options are not set.'),
            default => null,
        };
    }

    /** @inheritDoc */
    public function withEntries(Traversable $entries): IInfinitePaletteTemplateBuilder
    {
        $clone = clone $this;
        $clone->entries = $entries;
        return $clone;
    }

    public function withOptions(IPaletteOptions $options): IInfinitePaletteTemplateBuilder
    {
        $clone = clone $this;
        $clone->options = $options;
        return $clone;
    }
}
