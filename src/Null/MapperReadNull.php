<?php

namespace App\Null;

use App\Contract\Connector\Mapper\MapperReadInterface;

class MapperReadNull implements MapperReadInterface
{
    public function fromState(array $state)
    {
        return;
    }

    public function validateState(array $state)
    {
        return;
    }

}