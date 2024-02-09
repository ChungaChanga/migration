<?php declare(strict_types=1);

namespace App\Connector;

use App\Entity\AbstractEntity;
use App\Event\EntitiesCreateAfterEvent;
use App\Event\EntitiesCreateBeforeEvent;
use App\Event\EntitiesCreateErrorEvent;
use App\Contract\Connector\Mapper\MapperWriteInterface;
use App\Contract\Connector\Repository\StorageWriteInterface;
use App\Migration\EntityTransferStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ConnectorWriteType
{
    public function __construct(
        private StorageWriteInterface  $storage,
        private EntityManagerInterface $entityManager,
        private MapperWriteInterface   $mapper,
    )
    {
    }

    public function create(ArrayCollection $entities): void
    {
        /** @var AbstractEntity $entity */
        foreach ($entities as $entity) {
            $this->entityManager->persist($entity);
            $entityState = $this->mapper->getState($entity);
            try {
                $this->saveEntityTransferStatus($entity, EntityTransferStatus::Processing);
                $result = $this->storage->createOne($entityState);
                $entity->setDestId($result['id']);
                $entity->setTransferStatus(EntityTransferStatus::Done);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $this->saveEntityTransferStatus($entity, EntityTransferStatus::Error);
            }
        }
    }

    private function saveEntityTransferStatus(AbstractEntity $entity, EntityTransferStatus $status)
    {
        $entity->setTransferStatus($status);
        $this->entityManager->flush();
    }

    public function getStorage(): StorageWriteInterface
    {
        return $this->storage;
    }

    public function setStorage(StorageWriteInterface $storage): void
    {
        $this->storage = $storage;
    }

    public function getMapper(): MapperWriteInterface
    {
        return $this->mapper;
    }

    public function setMapper(MapperWriteInterface $mapper): void
    {
        $this->mapper = $mapper;
    }
}