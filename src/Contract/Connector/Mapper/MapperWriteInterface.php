<?php

namespace App\Contract\Connector\Mapper;


use App\Entity\AbstractEntity;

interface MapperWriteInterface
{
    public function getState(AbstractEntity $order): array;
}