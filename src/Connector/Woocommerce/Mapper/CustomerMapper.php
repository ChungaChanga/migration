<?php

namespace App\Connector\Woocommerce\Mapper;


use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Product;
use App\Exception\InvalidStateException;
use App\Contract\Connector\Mapper\MapperReadInterface;

class CustomerMapper implements MapperReadInterface
{
    public function fromState(array $state)
    {
        $this->validateState($state);

        $customer = new Customer();

        $customer->setSourceId($state['id']);
        $customer->setFirstName($state['first_name']);
        $customer->setLastName($state['last_name']);//todo
        $customer->setEmail($state['email']);//todo

        return $customer;
    }

    public function validateState(array $state)
    {
        if (!array_key_exists('id', $state)) {
            throw new InvalidStateException('property id is required');
        }
        if (!array_key_exists('email', $state)) {
            throw new InvalidStateException('property email is required');
        }
        if (!array_key_exists('first_name', $state)) {
            throw new InvalidStateException('property first_name is required');
        }
        if (!array_key_exists('last_name', $state)) {
            throw new InvalidStateException('property last_name is required');
        }
    }
}