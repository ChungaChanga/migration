<?php

namespace App\Connector\Woocommerce\Mapper;


use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Product;
use App\Exception\InvalidStateException;
use App\Contract\Connector\Mapper\MapperReadInterface;

class CustomerMapper implements MapperReadInterface
{
    public function fromState(array $state): Customer
    {
        $this->validateState($state);

        $customer = new Customer();

        $customer->setSourceId($state['Id']);
        $customer->setFirstName($state['Fullname']);
        $customer->setEmail($state['Email']);//todo

        return $customer;
    }

    public function validateState(array $state)
    {
        if (!array_key_exists('Id', $state)) {
            throw new InvalidStateException('property id is required');
        }
        if (!array_key_exists('Email', $state)) {
            throw new InvalidStateException('property email is required');
        }
    }
}