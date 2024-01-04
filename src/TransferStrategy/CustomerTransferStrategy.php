<?php

namespace App\TransferStrategy;

use App\Entity\AbstractEntity;
use App\EntityTransferStatus;
use Chungachanga\AbstractMigration\Connector\ConnectorWriterInterface;
use Chungachanga\AbstractMigration\Migration\TransferStrategyInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;

class CustomerTransferStrategy implements TransferStrategyInterface
{
    public function __construct(
        private ConnectorWriterInterface $destinationConnector,
        private EntityManagerInterface $entityManager
    )
    {

    }
    /**
     * Unsafe operation (write to destination repository)
     * @param $entities
     * @return void
     */
    public function transfer($entities)
    {
        /** @var AbstractEntity[] $entities  */
        //create entity
        $mapper = $this->destinationConnector->getMapper();
        $repository = $this->destinationConnector->getRepository();
        foreach ($entities as $entity) {
            try {
                $this->entityManager->persist($entity);

                $entity->setTransferStatus(EntityTransferStatus::Processing);
                $this->entityManager->flush();
                $s = $mapper->getState($entity);
                $destId = $repository->createOne($s);

                $entity->setTransferStatus(EntityTransferStatus::Done);
                $entity->setDestId($destId);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $entity->setTransferStatus(EntityTransferStatus::Error);
                $entity->setTransferData($e->getMessage());
                $this->entityManager->flush();
            }

        }


        //save entity state
        //fixme
//        $entities[0]->setDest
//        $this->entityManager

        //todo: rollback
    }
}