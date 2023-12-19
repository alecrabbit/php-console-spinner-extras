<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Widget\A\AWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Exception\RuntimeException;
use AlecRabbit\Spinner\Extras\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Extras\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Extras\Widget\WidgetContext;

abstract class AWidgetComposite extends AWidget implements IWidgetComposite
{
    protected IInterval $interval;

    public function __construct(
        IWidgetRevolver $revolver,
        IFrame $leadingSpacer,
        IFrame $trailingSpacer,
        protected readonly IIntervalComparator $intervalComparator,
        protected readonly IWidgetCompositeChildrenContainer $children = new WidgetCompositeChildrenContainer(),
        ?IObserver $observer = null,
    ) {
        parent::__construct(
            $revolver,
            $leadingSpacer,
            $trailingSpacer,
            $observer
        );

        $this->observer = $this->initializeObserver($observer);

        $this->interval = $this->widgetRevolver->getInterval();
        $this->children->attach($this);
        $this->update($this->children);
    }

    protected function initializeObserver(?IObserver $observer): ?IObserver
    {
        if ($observer instanceof IWidgetContext) {
            $observer->setWidget($this);
            return $observer;
        }
        if ($observer === null) {
            return new WidgetContext($this);
        }
        return null;
    }

    public function getInterval(): IInterval
    {
        return $this->interval;
    }

    public function update(ISubject $subject): void
    {
        $this->assertNotSelf($subject);

        if ($subject === $this->children) {
            $interval = $this->intervalComparator->smallest($this->interval, $subject->getInterval());

            if ($this->interval !== $interval) {
                $this->interval = $interval;
                $this->notify();
            }
        }
    }

    public function getFrame(?float $dt = null): ICharFrame
    {
        $frame = parent::getFrame($dt);

        if (!$this->children->isEmpty()) {
            /** @var IWidgetContext $context */
            foreach ($this->children as $context => $_) {
                $widget = $context->getWidget();
                if ($widget instanceof IWidget) {
                    $f = $widget->getFrame($dt);

                    $frame = $this->createFrame(
                        $frame->getSequence() . $f->getSequence(),
                        $frame->getWidth() + $f->getWidth(),
                    );
                }
            }
        }

        return $frame;
    }

    public function getContext(): IWidgetContext
    {
        if ($this->observer instanceof IWidgetContext) {
            return $this->observer;
        }
        throw new RuntimeException(sprintf('Observer is not an instance of %s', IWidgetContext::class));
    }

    public function add(IWidgetContext $context): IWidgetContext
    {
        return $this->children->add($context);
    }

    public function remove(IWidgetContext $context): void
    {
        if ($this->children->has($context)) {
            $this->children->remove($context);
        }
    }

    protected function assertObserverIsNotAttached(): void
    {
        // do nothing
    }
}
