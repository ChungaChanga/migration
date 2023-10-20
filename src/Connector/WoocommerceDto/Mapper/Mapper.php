<?php

namespace App\Connector\WoocommerceDto\Mapper;


use Chungachanga\AbstractMigration\Entity\EntityInterface;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;

class Mapper implements MapperReadInterface
{
    public function fromState(array $state): EntityInterface
    {

        $customer = new Customer();

        $customer->setId($state['Id']);
        $customer->setFirstName($state['Fullname']);//todo
//        $customer->setLastName($state['last_name']);
        return $customer;
    }
}