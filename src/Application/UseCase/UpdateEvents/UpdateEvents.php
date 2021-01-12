<?php


namespace App\Application\UseCase\UpdateEvents;


class UpdateEvents
{
    private string $uuid;
    private array $events;

    public function __construct(string $uuid, array $events)
    {
        $this->uuid = $uuid;
        $this->events = $events;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param array $events
     */
    public function setEvents(array $events): void
    {
        $this->events = $events;
    }


}