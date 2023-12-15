<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Settings\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Extras\Settings\Contract\IMultiWidgetSettings;
use ArrayObject;
use Traversable;

abstract readonly class AMultiWidgetSettings implements IMultiWidgetSettings
{
    /** @var ArrayObject<int, IWidgetSettings> */
    private ArrayObject $other;

    public function __construct(
        private IWidgetSettings $first,
        IWidgetSettings ...$other,
    ) {
        /** @var array<int, IWidgetSettings> $other */
        $this->other = new ArrayObject($other);
    }

    /** @inheritDoc */
    abstract public function getIdentifier(): string;

    public function getLeadingSpacer(): ?IFrame
    {
        return $this->first->getLeadingSpacer();
    }

    public function getTrailingSpacer(): ?IFrame
    {
        return $this->first->getTrailingSpacer();
    }

    public function getStylePalette(): ?IStylePalette
    {
        return $this->first->getStylePalette();
    }

    public function getCharPalette(): ?ICharPalette
    {
        return $this->first->getCharPalette();
    }

    /** @inheritDoc */
    public function getAll(): Traversable
    {
        yield $this->first;
        yield from $this->other;
    }

    /** @inheritDoc */
    public function getOther(): Traversable
    {
        yield from $this->other;
    }

    public function getFirst(): IWidgetSettings
    {
        return $this->first;
    }
}
