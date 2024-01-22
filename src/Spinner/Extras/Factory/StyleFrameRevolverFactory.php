<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Extras\Pattern\Contract\IInfinitePattern;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Extras\Revolver\Builder\Contract\IStyleFrameRevolverBuilder;

final readonly class StyleFrameRevolverFactory implements IStyleFrameRevolverFactory
{
    public function __construct(
        private IStyleFrameRevolverBuilder $frameRevolverBuilder,
        private IFrameCollectionRevolverBuilder $frameCollectionRevolverBuilder,
        private IFrameCollectionFactory $frameCollectionFactory,
        private IRevolverConfig $revolverConfig,
        private IStyleRenderer $styleRenderer,
    ) {
    }

    public function create(IPattern $pattern): IFrameRevolver
    {
        if ($pattern instanceof IInfinitePattern) {
            return $this->frameRevolverBuilder
                ->withFrames(
                    $pattern->getFrames()
                )
                ->withInterval($pattern->getInterval())
                ->withTolerance($this->revolverConfig->getTolerance())
                ->withStyleRenderer($this->styleRenderer)
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
