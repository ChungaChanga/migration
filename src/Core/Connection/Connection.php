<?php

namespace App\Core\Connection;

use App\Core\ConnectorFactory\FactoryReaderInterface;
use App\Core\ConnectorFactory\FactoryWriterInterface;
use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use App\Core\ConnectorInterface\Repository\RepositoryWriteInterface;
use App\Core\Iterator\AwaitingIterator;
use App\Core\Mapper\MapperReadInterface;
use App\Core\Mapper\MapperWriteInterface;
use Iterator;

class Connection
{

    private bool $isTransferActive;

    public function __construct(
        private RepositoryReadInterface $sourceRepository,
        private MapperReadInterface $sourceMapper,
        private RepositoryWriteInterface $destinationRepository,
        private MapperWriteInterface $destinationMapper,
        private Iterator $iterator,
    )
    {

    }

    public function transferStart(int $startPosition, int $endPosition, int $batchSize, int $jumpSize = 0, int $delaySeconds = 1)
    {
        $this->isTransferActive = true;

        foreach ($this->iterator as $repositoryIteratorKey => $sourceEntitiesState) {
            if (!$this->isTransferActive()) {
                break;
            }
            if ($delaySeconds > 0) {
                sleep($delaySeconds);
            }

            $entityStorage = new \SplObjectStorage();
            foreach ($sourceEntitiesState as $state) {
                $entityStorage->attach($this->sourceMapper->fromState($state));
            }

            //handle by decorator\visitor?

            $destinationEntitiesState = [];
            foreach ($entityStorage as $entity) {
                $destinationEntitiesState[] = $this->destinationMapper->getState($entity);
            }
            $this->destinationRepository->create($destinationEntitiesState);

            $entityStorage->removeAll($entityStorage);
        }
    }

    public function transferStop()
    {
        $this->isTransferActive = false;
    }

    public function isTransferActive()
    {
        return $this->isTransferActive;
    }

    public function getSourceRepository(): RepositoryReadInterface
    {
        return $this->sourceRepository;
    }

    public function getDestinationRepository(): RepositoryWriteInterface
    {
        return $this->destinationRepository;
    }
}