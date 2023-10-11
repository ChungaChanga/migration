<?php

namespace App\Connector\Interface;

interface WriteConnectorInterface
{
    public function createCustomers(array $customers);
}