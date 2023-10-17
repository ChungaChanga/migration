<?php

namespace App\Core\Migration;

use App\Core\ConnectorAbstract\Connector\ConnectorWriterInterface;
use SplObjectStorage;

class TransferStrategy
{
    public function __construct(
        private ConnectorWriterInterface $destinationConnector,
    )
    {
    }

    /**
     * Unsafe operation (write to destination repository)
     * @param SplObjectStorage $entities
     * @return void
     */
    public function transfer(SplObjectStorage $entities)
    {
        $destinationEntitiesState = [];
        foreach ($entities as $entity) {
            $destinationEntitiesState[] = $this->destinationConnector->getMapper()->getState($entity);
        }
        $this->destinationConnector->getRepository()->create($destinationEntitiesState);
    }
}