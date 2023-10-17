<?php

namespace App\Connector\Magento\Mapper;

use App\Core\ConnectorInterface\Mapper\MapperWriteInterface;
use App\Core\Entity\Customer;
use App\Core\Entity\EntityInterface;

class CustomerMapper implements MapperWriteInterface
{
    public function getState(EntityInterface $entity): array
    {
        /**@var Customer $entity */
        return [
            'id' => $entity->getId()
        ];
    }
}