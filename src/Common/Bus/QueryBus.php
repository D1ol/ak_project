<?php

namespace App\Common\Bus;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBus implements QueryBusInterface
{
    private MessageBusInterface $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function dispatch($message, array $stamps = [])
    {
        $envelope = $this->queryBus->dispatch($message);

        return $envelope->last(HandledStamp::class)->getResult();
    }
}
