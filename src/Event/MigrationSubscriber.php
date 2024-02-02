<?php

namespace App\Event;

use App\Migration\EntityTransferStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MigrationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }
    public static function getSubscribedEvents()
    {
       return [
           EntitiesCreateBeforeEvent::NAME => 'onEntitiesCreateBefore',
           EntitiesCreateAfterEvent::NAME => 'onEntitiesCreateAfter',
           EntitiesCreateErrorEvent::NAME => 'onEntitiesCreateError',
       ];
    }

    public function onEntitiesCreateBefore(EntitiesCreateBeforeEvent $event)
    {
        foreach ($event->getEntities() as $entity) {
            $this->entityManager->persist($entity);
            $entity->setTransferStatus(EntityTransferStatus::Processing);
        }
        $this->entityManager->flush();
    }

    public function onEntitiesCreateAfter(EntitiesCreateAfterEvent $event)
    {
        foreach ($event->getEntities() as $entity) {
            $this->entityManager->persist($entity);
            $entity->setTransferStatus(EntityTransferStatus::Done);
        }
        $this->entityManager->flush();
    }

    public function onEntitiesCreateError(EntitiesCreateErrorEvent $event)
    {
        foreach ($event->getEntities() as $entity) {
            $this->entityManager->persist($entity);
            $entity->setTransferStatus(EntityTransferStatus::Error);
           // $entity->setTransferData($e->getMessage());//todo
        }
        $this->entityManager->flush();
    }
}