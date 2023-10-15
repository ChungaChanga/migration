<?php

namespace App\Core\Transfer\Strategy;

use App\Core\Connection\ConnectionInterface;
use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use Iterator;
use InvalidArgumentException;

class BatchStrategy implements StrategyInterface
{
    public function __construct(
        private ConnectionInterface $connection,
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
        if ($startBatchNumber >= $endBatchNumber) {
            throw new InvalidArgumentException('Start Batch Number must be more than End Batch Number');
        }
    }

    public function start()
    {
        $sourceRepository = $this->connection->getSourceConnector()->getRepository();
        $sourceMapper = $this->connection->getSourceConnector()->getMapper();
        $destinationRepository = $this->connection->getDestinationConnector()->getRepository();
        $destinationMapper = $this->connection->getDestinationConnector()->getMapper();
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

            //handle by decorator\visitor?

            $destinationEntitiesState = [];
            foreach ($entityStorage as $entity) {
                $destinationEntitiesState[] = $destinationMapper->getState($entity);
            }
            $destinationRepository->create($destinationEntitiesState);

            $entityStorage->removeAll($entityStorage);
        }
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