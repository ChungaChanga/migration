<?php

namespace App\Connector\Woocommerce\Mapper;

use App\Core\ConnectorAbstract\Mapper\MapperReadInterface;
use App\Core\Entity\Customer;

class CustomerMapper implements MapperReadInterface
{
    public function fromState(array $state): Customer
    {

        $customer = new Customer();

        $customer->setId($state['Id']);
        $customer->setFirstName($state['Fullname']);//todo
//        $customer->setLastName($state['last_name']);
        return $customer;
    }
}