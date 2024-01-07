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
        private MigrationState $state,
        private HandlerInterface $entityHandler,
    )
    {
    }
    public function start()
    {
        /**
         * @var ArrayCollection $entities
         */
        foreach ($this->sourceConnector->getIterator() as $pageNum => $entities) {
            if ($this->state->getDelaySeconds() > 0) {
                sleep($this->state->getDelaySeconds());
            }
            if ($entities->isEmpty() && false === $this->state->getIsNeedWaiting()) {
                break;
            }
            $this->entityHandler->handle($entities);
            $this->destConnector->create($entities);
        }
    }
}