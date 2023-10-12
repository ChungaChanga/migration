<?php

namespace App\Connection;

use App\ConnectorFactory\FactoryReadInterface;
use App\ConnectorFactory\FactoryWriteInterface;
use App\Iterator\AwaitingIterator;

class Connection
{
    public function transferEntities(
        FactoryReadInterface $sourceFactory,
        FactoryWriteInterface $destinationFactory,
    )
    {
        $sourceRepository = $sourceFactory->createRepository();
        $sourceMapper = $sourceFactory->createMapper();

        $destinationRepository = $destinationFactory->createRepository();
        $destinationMapper = $destinationFactory->createMapper();

        $iterator = new AwaitingIterator($sourceRepository, 10);

        foreach ($iterator as $repositoryIteratorKey => $sourceEntitiesState) {
            $entityStorage = new \SplObjectStorage();

            foreach ($sourceEntitiesState as $state) {
                $entityStorage->attach($sourceMapper->fromState($state));
            }

            //handle by decorator?

            $destinationEntitiesState = [];
            foreach ($entityStorage as $entity) {
                $destinationEntitiesState[] = $destinationMapper->getState($entity);
            }
            $destinationRepository->create($destinationEntitiesState);

            $entityStorage->removeAll($entityStorage);
        }
    }

}