<?php

namespace App\Migration;

use Chungachanga\AbstractMigration\Connection\ConnectionInterface;
use Chungachanga\AbstractMigration\EntityHandler\HandlerInterface;
use Chungachanga\AbstractMigration\Migration\MigrationInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Chungachanga\AbstractMigration\Migration\TransferStrategyInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Iterator;

class Migration implements MigrationInterface
{
    public function __construct(
        private ConnectionInterface $connection,
        private TransferStrategyInterface $strategy,
        private MigrationState $state,
        private HandlerInterface $entityHandler,
    )
    {
        $this->entityCollection = new ArrayCollection();
    }
    public function start()
    {
        $sourceRepository = $this->connection->getSourceConnector()->getRepository();
        $sourceMapper = $this->connection->getSourceConnector()->getMapper();
        $iterator = $this->createIterator($sourceRepository);

        foreach ($iterator as $currentBatchNumber => $sourceEntitiesState) {
            $this->entityCollection->clear();
            if ($currentBatchNumber > $this->state->getEndBatchNumber()) {
                break;
            }
            if ($this->state->getDelaySeconds() > 0) {
                sleep($this->state->getDelaySeconds());
            }
            foreach ($sourceEntitiesState as $state) {

                $this->entityCollection->add($sourceMapper->fromState($state));
            }

            $this->entityHandler->handle($this->entityCollection);

            $this->strategy->transfer($this->entityCollection);
        }
    }

    protected function createIterator(RepositoryReadInterface $repository): Iterator
    {
        return $repository->createAwaitingPageIterator(
            $this->state->getStartBatchNumber(),
            $this->state->getBatchSize(),
            $this->state->getJumpSize()
        );
    }
}