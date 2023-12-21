<?php

namespace App\Common\EventManager;

trait EventsCollectorTrait
{
    /**
     * @var EventInterface[]
     */
    private array $events = [];

    public function record(EventInterface $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @param EventInterface[] $events
     */
    public function recordMulti(array $events): void
    {
        foreach ($events as $event) {
            $this->record($event);
        }
    }

    /**
     * @return EventInterface[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return EventInterface[]
     */
    public function pullEvents(): array
    {
        $events = $this->getEvents();
        $this->events = [];

        return $events;
    }
}
