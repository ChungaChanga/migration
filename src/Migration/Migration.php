<?php

namespace App\Migration;

use App\Connector\ConnectorReadType;
use App\Connector\ConnectorWriteType;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;

class Migration
{
    public function __construct(
        private ConnectorReadType $sourceConnector,
        private ConnectorWriteType $destConnector,
        private LoggerInterface $logger,
    )
    {
    }
    public function start(): void
    {
        /**
         * @var ArrayCollection $entities
         */
        foreach ($this->sourceConnector->getIterator() as $pageNum => $entities) {
            if ($entities->isEmpty()) {
                continue;
            }
            $this->logger->error('page ' . $pageNum . PHP_EOL);
            $this->destConnector->create($entities);
        }
    }
}