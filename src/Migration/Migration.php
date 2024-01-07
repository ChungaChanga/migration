<?php

namespace App\Migration;

use App\Connector\ConnectorReadType;
use App\Connector\ConnectorWriteType;
use Chungachanga\AbstractMigration\Connection\ConnectionInterface;
use Chungachanga\AbstractMigration\EntityHandler\HandlerInterface;
use Chungachanga\AbstractMigration\Migration\MigrationInterface;
use Chungachanga\AbstractMigration\Migration\TransferStrategyInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Iterator;

class Migration implements MigrationInterface
{
    public function __construct(
        private ConnectorReadType $sourceConnector,
        private ConnectorWriteType $destConnector,
        private HandlerInterface $entityHandler,
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
            $this->entityHandler->handle($entities);
            $this->destConnector->create($entities);
        }
    }
}