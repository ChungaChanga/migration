<?php

namespace App\Null;

use Chungachanga\AbstractMigration\Mapper\MapperWriteInterface;

class MapperWriteNull implements MapperWriteInterface
{
    public function getState($entity): array
    {
        return [];
    }

}