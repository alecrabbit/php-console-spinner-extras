<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Extras\Value\Contract\IFloatWrapper;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueReference;
use AlecRabbit\Spinner\Extras\Value\Contract\IValueWrapper;

use function AlecRabbit\WCWidth\wcswidth;

abstract class AFloatValueProcedure extends AProcedure
{
    private const FORMAT = '%s';
    protected readonly IValueWrapper $wrapper;

    public function __construct(
        IValueReference $reference,
        protected readonly string $format = self::FORMAT,
        IPaletteOptions $options = new PaletteOptions(),
    ) {
        parent::__construct($reference, $options);

        $this->wrapper = $this->reference->getWrapper();
    }

    public function getFrame(?float $dt = null): IFrame
    {
        return $this->createSequenceFrame(
            $this->createFrameSequence()
        );
    }

    private function createSequenceFrame(string $sequence): ISequenceFrame
    {
        if ($sequence === '') {
            return new CharSequenceFrame('', 0);
        }
        return new CharSequenceFrame($sequence, $this->getWidth($sequence));
    }

    protected function getWidth(string $value): int
    {
        return wcswidth($value); // TODO (2024-02-27 13:25) [Alec Rabbit]: [431c50df-f9be-4a7e-b79c-569fd74470a5]
    }

    private function createFrameSequence(): string
    {
        return sprintf(
            $this->format,
            $this->wrapper->unwrap()
        );
    }

    protected function assertReference(): void
    {
        if (!$this->reference->getWrapper() instanceof IFloatWrapper) {
            throw new InvalidArgument(
                sprintf(
                    'Reference value is expected to contain an instance of %s.',
                    IFloatWrapper::class
                )
            );
        }
    }
}
