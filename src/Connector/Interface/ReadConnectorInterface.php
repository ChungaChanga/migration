<?php

namespace App\Connector\Interface;

interface ReadConnectorInterface
{
    public function getCustomers(int $count): array;
}