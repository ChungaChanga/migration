<?php

namespace App\Connector\Magento\Mapper;

use App\Entity\Product;
use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;

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