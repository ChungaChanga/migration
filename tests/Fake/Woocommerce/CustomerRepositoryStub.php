<?php

namespace App\Tests\Fake\Woocommerce;

use App\Connector\Woocommerce\Repository\CustomerRepository;
use Chungachanga\AbstractMigration\Repository\RepositoryFullInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerRepositoryStub extends CustomerRepository implements RepositoryFullInterface
{
    private array $entities = [];

    public function __construct()
    {

    }

    public function create(array $entities)
    {
        $this->entities = array_merge($this->entities, $entities);
    }

    public function createOne($entity)//todo interface and type
    {
        $this->entities[] = $entity;
        return count($this->entities) - 1;
    }

    public function fetch(int $start, int $end): array
    {
        return array_slice($this->entities, $start, $end - $start);
    }

    public function fetchPage(int $page, int $pageSize): array
    {
        $this->validatePage($page);
        $res = array_slice($this->entities, ($page - 1) * $pageSize, $pageSize);
        return $res;
    }
}