<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Extras\Pattern\Contract\IInfinitePattern;
use AlecRabbit\Spinner\Extras\Revolver\Builder\Contract\ICharFrameRevolverBuilder;

final readonly class CharFrameRevolverFactory implements ICharFrameRevolverFactory
{
    public function __construct(
        private ICharFrameRevolverBuilder $frameRevolverBuilder,
        private IFrameCollectionRevolverBuilder $frameCollectionRevolverBuilder,
        private IPatternFactory $patternFactory,
        private IFrameCollectionFactory $frameCollectionFactory,
        private IRevolverConfig $revolverConfig,
    ) {
    }

    public function create(IPalette $palette): IFrameRevolver
    {
        $pattern = $this->patternFactory->create($palette);

        if ($pattern instanceof IInfinitePattern) {
            return $this->frameRevolverBuilder
                ->withFrames(
                    $pattern->getFrames()
                )
                ->withInterval($pattern->getInterval())
                ->withTolerance($this->revolverConfig->getTolerance())
                ->build()
            ;
        }

        return $this->frameCollectionRevolverBuilder
            ->withFrames(
                $this->frameCollectionFactory->create(
                    $pattern->getFrames()
                )
            )
            ->withInterval($pattern->getInterval())
            ->withTolerance($this->revolverConfig->getTolerance())
            ->build()
        ;
    }
}
