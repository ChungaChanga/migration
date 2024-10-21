<?php

namespace App\Connector\Memory\Mapper;


use App\Contract\Connector\Mapper\MapperWriteInterface;
use App\Entity\AbstractEntity;
use App\Entity\Customer;

class CustomerMapper implements MapperWriteInterface
{
    public function getState(AbstractEntity $entity): array
    {
        /**
         * @var Customer $entity
         */
        return [
            'source_id' => $entity->getSourceId(),
            'email' => $entity->getEmail()
        ];
    }
}