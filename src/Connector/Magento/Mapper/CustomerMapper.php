<?php

namespace App\Connector\Magento\Mapper;


use App\Entity\Customer;
use App\Contract\Connector\Mapper\MapperWriteInterface;

class CustomerMapper implements MapperWriteInterface
{
    /**
     * @param Customer $entity
     * @return array
     */
    public function getState($entity): array
    {
        return [
            'customer' => [
                'email' => $entity->getEmail(),//required
                'firstname' => $entity->getFirstName(),//required
                'lastname' => $entity->getLastName(),//required
            ],
            'password' => 'password123Q',
        ];
    }
}