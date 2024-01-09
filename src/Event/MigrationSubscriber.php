<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MigrationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
       return [
           EntitiesCreateAfterEvent::NAME => 'onEntitiesCreateAfter'
       ];
    }

    public function onEntitiesCreateAfter(EntitiesCreateAfterEvent $event)
    {

    }
}