<?php

namespace App\Core\Migration;

use App\Core\Connection\ConnectionInterface;
use App\Core\ConnectorAbstract\Repository\RepositoryReadInterface;
use App\Core\EntityHandler\HandlerInterface;
use InvalidArgumentException;
use Iterator;

class Migration
{
    public function __construct(
        private ConnectionInterface $connection,
        private HandlerInterface $entityHandler,
        private TransferStrategy $strategy,
        private int $startBatchNumber,
        private int $batchSize,
        private int $endBatchNumber = PHP_INT_MAX,
        private int $jumpSize = 0,
        private int $delaySeconds = 0
    )
    {
        if ($startBatchNumber < 0) {
            throw new InvalidArgumentException('Start Batch Number can not be a negative number');
        }
        if ($jumpSize < 0) {
            throw new InvalidArgumentException('Jump Size can not be a negative number');
        }
        if ($delaySeconds < 0) {
            throw new InvalidArgumentException('Delay Seconds can not be a negative number');
        }
        if ($startBatchNumber > $endBatchNumber) {
            throw new InvalidArgumentException('Start Batch Number can not be more than End Batch Number');
        }
    }
    public function start()
    {
        $sourceRepository = $this->connection->getSourceConnector()->getRepository();
        $sourceMapper = $this->connection->getSourceConnector()->getMapper();
        $iterator = $this->createIterator($sourceRepository);

        foreach ($iterator as $currentBatchNumber => $sourceEntitiesState) {
            if ($currentBatchNumber > $this->endBatchNumber) {
                break;
            }
            if ($this->delaySeconds > 0) {
                sleep($this->delaySeconds);
            }
            $entityStorage = new \SplObjectStorage();
            foreach ($sourceEntitiesState as $state) {
                $entityStorage->attach($sourceMapper->fromState($state));
            }

            $this->entityHandler->handle($entityStorage);

            $this->strategy->transfer($entityStorage);

            $entityStorage->removeAll($entityStorage);
        }
    }

    public function getState(): MigrationState
    {
        return new MigrationState(
            $this->startBatchNumber,
            $this->batchSize,
            $this->endBatchNumber,
            $this->jumpSize,
            $this->delaySeconds,
        );
    }

    public static function fromState(ConnectionInterface $connection, MigrationState $state): static
    {
        return new static(
//            $connection,
//            $state->getStartBatchNumber(),
//            $state->getBatchSize(),
//            $state->getEndBatchNumber(),
//            $state->getJumpSize(),
//            $state->getDelaySeconds(),
        );
    }

    protected function createIterator(RepositoryReadInterface $repository): Iterator
    {
        return $repository->createAwaitingPageIterator(
            $this->startBatchNumber,
            $this->batchSize,
            $this->jumpSize
        );
    }
}