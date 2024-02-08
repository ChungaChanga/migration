<?php

namespace App\Connector\Magento\Mapper;


use App\Entity\Customer;
use App\Contract\Connector\Mapper\MapperWriteInterface;

class CustomerMapper implements MapperWriteInterface
{
    /**
     * @param Customer $order
     * @return array
     */
    public function getState($order): array
    {
        return [
            'customer' => [
                'email' => $order->getEmail(),//required
                'firstname' => $order->getFirstName(),//required
                'lastname' => $order->getLastName(),//required
            ],
            'password' => 'password123Q',
        ];
    }
}