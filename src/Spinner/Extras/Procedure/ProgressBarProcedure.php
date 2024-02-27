<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Extras\Contract\IProgressBarSprite;
use AlecRabbit\Spinner\Extras\Procedure\A\AProgressValueProcedure;
use AlecRabbit\Spinner\Extras\ProgressBarSprite;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;

/**
 * @psalm-suppress UnusedClass
 */
final class ProgressBarProcedure extends AProgressValueProcedure implements ICharPalette
{
    private const UNITS = 5;
    private readonly float $cursorThreshold;
    private readonly int $units;

    public function __construct(
        IValueReference $reference,
        int $units = self::UNITS,
        private readonly IProgressBarSprite $sprite = new ProgressBarSprite(),
        private readonly bool $withCursor = true,
        IPaletteOptions $options = new PaletteOptions(interval: 300),
    ) {
        parent::__construct($reference, options: $options);

        $this->cursorThreshold = $this->wrapper->getMax();
        $this->units = $this->withCursor ? $units - 1 : $units;
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createSequenceFrame(
            $this->createBar($this->wrapper->unwrap())
        );
    }

    private function createSequenceFrame(string $sequence): ISequenceFrame
    {
        if ($sequence === '') {
            return new CharSequenceFrame('', 0);
        }
        return new CharSequenceFrame($sequence, $this->getWidth($sequence));
    }

    private function createBar(float $progress): string
    {
        $p = (int)($progress * $this->units);

        $cursor =
            $this->withCursor
                ? $this->getCursor($progress)
                : '';

        return $this->sprite->getOpen() .
            str_repeat($this->sprite->getDone(), $p) .
            $cursor .
            str_repeat($this->sprite->getEmpty(), $this->units - $p) .
            $this->sprite->getClose();
    }

    private function getCursor(float $fraction): string
    {
        return $fraction >= $this->cursorThreshold
            ? $this->sprite->getDone()
            : $this->sprite->getCursor();
    }
}
