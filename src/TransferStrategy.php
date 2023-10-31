<?php

namespace App;

use Chungachanga\AbstractMigration\Collection\EntityCollectionInterface;
use Chungachanga\AbstractMigration\Connector\ConnectorWriterInterface;
use Chungachanga\AbstractMigration\Migration\TransferStrategyInterface;
use Doctrine\ORM\EntityManagerInterface;

class TransferStrategy implements TransferStrategyInterface
{
    public function __construct(
        private ConnectorWriterInterface $destinationConnector,
        private EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * Unsafe operation (write to destination repository)
     * @param EntityCollectionInterface $entities
     * @return void
     */
    public function transfer(EntityCollectionInterface $entities)
    {
        $destinationEntitiesState = [];
        foreach ($entities as $entity) {
            $destinationEntitiesState[] = $this->destinationConnector->getMapper()->getState($entity);
        }
        $this->destinationConnector->getRepository()->create($destinationEntitiesState);
    }
}