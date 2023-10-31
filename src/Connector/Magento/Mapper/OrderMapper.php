<?php

namespace App\Connector\Magento\Mapper;

use App\Entity\Order;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;

class OrderMapper implements MapperWriteInterface
{
    /**
     * @param Order $entity
     * @return array
     */
    public function getState($entity): array
    {
        return [
            'base_grand_total' => $entity->getTotal(),//required
            'grand_total' => $entity->getTotal(),//required
//            'customer_email' //required
//            'items'        //required
        ];
    }
}