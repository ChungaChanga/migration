<?php

namespace App\Connector\Memory\Mapper;

use App\Entity\Customer;
use Chungachanga\AbstractMigration\Mapper\MapperFullInterface;

class CustomerMapper implements MapperFullInterface
{
    public function fromState(array $state): Customer
    {
        $customer = new Customer();
        $customer->setEmail($state['email']);
        $customer->setFirstName($state['firstname']);
        $customer->setLastName($state['lastname']);

        return $customer;
    }

    public function getState($entity): array
    {
        /**@var Customer $entity */
        return [
            'email' => $entity->getEmail(),
            'firstname' => $entity->getFirstName(),
            'lastname' => $entity->getLastName(),
        ];
    }

}