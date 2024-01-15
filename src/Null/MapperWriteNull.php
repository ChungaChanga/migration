<?php

namespace App\Null;

use App\Contract\Connector\Mapper\MapperWriteInterface;

class MapperWriteNull implements MapperWriteInterface
{
    public function getState($entity): array
    {
        return [];
    }

}