<?php

namespace App\Connector\Woocommerce\Mapper;


use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Product;
use Chungachanga\AbstractMigration\Mapper\MapperReadInterface;

class CustomerMapper implements MapperReadInterface
{
    public function fromState(array $state)
    {
        $customer = new Customer();
        $customer->setSourceId($state['Id']);

        $name = explode(' ', $state['Fullname']);
        $customer->setFirstName($name[0] ?? '');//todo
        $customer->setLastName($name[1] ?? '');//todo
        $customer->setEmail($state['Email']);//todo

        return $customer;
    }

    public function validateState(array $state)
    {
        // TODO: Implement validateState() method.
    }
}