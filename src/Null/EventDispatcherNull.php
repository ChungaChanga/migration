<?php

namespace App\Null;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class EventDispatcherNull implements EventDispatcherInterface
{
    public function dispatch(object $event, string $eventName = null): object
    {
        return new \stdClass();
    }
}