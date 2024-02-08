<?php

namespace App\Connector\Magento\Mapper;

use App\Entity\Order;
use App\Contract\Connector\Mapper\MapperWriteInterface;

class OrderMapper implements MapperWriteInterface
{
    /**
     * @param Order $order
     * @return array
     */
    public function getState($order): array
    {
        return [
            'base_grand_total' => $order->getTotal(),//required
            'grand_total' => $order->getTotal(),//required
            'customer_email' => $order->getCustomer()->getEmail(),//required
//            'items'        //required
        ];
    }
}