<?php

namespace App\Connector\Woocommerce\Mapper;

use App\Core\Entity\Customer;
use App\Core\Mapper\MapperReadInterface;

class CustomerMapper implements MapperReadInterface
{
    public function fromState(array $state): Customer
    {
        $customer = new Customer();

        $customer->setId($state['ID']);
        $customer->setFirstName($state['first_name']);
        $customer->setLastName($state['last_name']);

        return $customer;
    }
}