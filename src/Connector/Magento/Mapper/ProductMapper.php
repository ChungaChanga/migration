<?php

namespace App\Connector\Magento\Mapper;

use App\Entity\Product;
use App\Contract\Connector\Mapper\MapperWriteInterface;

class ProductMapper implements MapperWriteInterface
{
    /**
     * @param Product $entity
     * @return array
     */
    public function getState($entity): array
    {
        return [
            'sku' => $entity->getDestSku()//required
        ];
    }
}