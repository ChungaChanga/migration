<?php

namespace App\Core\Connection;

use App\Core\ConnectorInterface\Connector\ConnectorReaderInterface;
use App\Core\ConnectorInterface\Connector\ConnectorWriterInterface;
use App\Core\Entity\EntityTypeInterface;
use App\Core\Exception\ConnectionTypeException;

class Connection
{
    public function __construct(
        private ConnectorReaderInterface $sourceConnector,
        private ConnectorWriterInterface $destinationConnector,
    )
    {
        $this->validateType($this->sourceConnector, $this->destinationConnector);
    }

    public function getSourceConnector(): ConnectorReaderInterface
    {
        return $this->sourceConnector;
    }

    public function getDestinationConnector(): ConnectorWriterInterface
    {
        return $this->destinationConnector;
    }

    private function validateType(
        EntityTypeInterface $sourceConnector,
        EntityTypeInterface $destinationConnector
    )
    {
        if ($sourceConnector->getType() !== $destinationConnector->getType()) {
            throw new ConnectionTypeException('Connections types must be equal');//todo refactoring
        }
    }
}