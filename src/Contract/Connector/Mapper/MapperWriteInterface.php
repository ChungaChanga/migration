<?php

namespace App\Contract\Connector\Mapper;


interface MapperWriteInterface
{
    public function getState($entity): array;
}