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

    public function transferBatch(SplObjectStorage $entities)
    {
        $destinationEntitiesState = [];
        foreach ($entities as $entity) {
            $destinationEntitiesState[] = $this->destinationConnector->getMapper()->getState($entity);
        }
        $this->destinationConnector->getRepository()->create($destinationEntitiesState);
    }
}