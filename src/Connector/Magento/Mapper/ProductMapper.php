<?php

namespace App\Connector\Magento\Mapper;

use App\Entity\Product;
use App\Contract\Connector\Mapper\MapperWriteInterface;

class ProductMapper implements MapperWriteInterface
{
    /**
     * @param Product $order
     * @return array
     */
    public function getState($order): array
    {
        return [
            'sku' => $order->getDestSku()//required
        ];
    }
}