<?php

namespace App\Tests\Fake\Woocommerce\Repository;

use App\Connector\Woocommerce\Repository\CustomerRepository;

class StubCustomerRepository extends CustomerRepository
{
    public function __construct(private array $customersState)
    {

    }

    public function fetchPage(int $page, int $pageSize): array
    {
        return array_slice($this->customersState, ($page - 1) * $pageSize, $pageSize);
    }
}