<?php

namespace App\Repository\Interface;

interface RepositoryWriteInterface
{
    public function create(array $entities);
}