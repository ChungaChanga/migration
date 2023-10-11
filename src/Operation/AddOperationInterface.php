<?php

namespace App\Operation;

use App\Repository\Interface\RepositoryInterface;

interface AddOperationInterface
{
    public function execute(
        RepositoryInterface $source,
        RepositoryInterface $destination,
    );
}