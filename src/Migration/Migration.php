<?php

namespace App\Migration;

use Chungachanga\AbstractMigration\Connection\ConnectionInterface;
use Chungachanga\AbstractMigration\EntityHandler\HandlerInterface;
use Chungachanga\AbstractMigration\Migration\MigrationInterface;
use Chungachanga\AbstractMigration\Migration\TransferStrategyInterface;
use Chungachanga\AbstractMigration\Repository\RepositoryReadInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Iterator;

class Migration implements MigrationInterface
{
    private MigrationStatus $status;
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
        $this->status = MigrationStatus::Run;
        $sourceRepository = $this->connection->getSourceConnector()->getRepository();
        $sourceMapper = $this->connection->getSourceConnector()->getMapper();
        $iterator = $this->createIterator($sourceRepository);

        foreach ($iterator as $currentBatchNumber => $sourceEntitiesState) {
            $this->entityCollection->clear();

            if (MigrationStatus::Pause === $this->status) {
                yield $currentBatchNumber;
            }

            if ($this->state->getDelaySeconds() > 0) {
                sleep($this->state->getDelaySeconds());
            }
            foreach ($sourceEntitiesState as $state) {
                $this->entityCollection->add($sourceMapper->fromState($state));
            }

            if ($this->entityCollection->isEmpty() && false === $this->state->getIsNeedWaiting()) {
                break;
            }

            $this->entityHandler->handle($this->entityCollection);

            $this->strategy->transfer($this->entityCollection);
        }
    }

    public function pause()
    {
        $this->status = MigrationStatus::Pause;
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