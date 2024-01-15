<?php

namespace App\Contract\Connector\Mapper;


use App\Entity\AbstractEntity;

interface MapperReadInterface
{
    public function fromState(array $state): AbstractEntity;
    public function validateState(array $state);
}