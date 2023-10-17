<?php

namespace App\Core\Migration;

use App\Core\Connection\ConnectionInterface;
use App\Core\ConnectorInterface\Connector\ConnectorWriterInterface;
use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use InvalidArgumentException;
use Iterator;
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