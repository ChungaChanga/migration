<?php

namespace App\Core\Connection;

use App\Core\ConnectorInterface\Connector\ConnectorReaderInterface;
use App\Core\ConnectorInterface\Connector\ConnectorWriterInterface;

interface ConnectionInterface
{
    public function getSourceConnector(): ConnectorReaderInterface;
    public function getDestinationConnector(): ConnectorWriterInterface;
    public function validateType();
}