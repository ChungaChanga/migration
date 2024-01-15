<?php

namespace App\Contract\Connector\Mapper;


interface MapperReadInterface
{
    public function fromState(array $state);
    public function validateState(array $state);
}