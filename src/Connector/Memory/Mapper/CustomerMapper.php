<?php

namespace App\Connector\Memory\Mapper;

use App\Core\ConnectorAbstract\Mapper\MapperInterface;
use App\Core\Entity\Customer;
use App\Core\Entity\EntityInterface;

class CustomerMapper implements MapperInterface
{
    public function fromState(array $state): Customer
    {
        $customer = new Customer();

        $customer->setId($state['id']);

        return $customer;
    }

    public function getState(EntityInterface $entity): array
    {
        /**@var Customer $entity */
        return [
            'id' => $entity->getId()
        ];
    }

}