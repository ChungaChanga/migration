<?php

namespace App\Connector\Memory\Storage;

use App\Connector\Woocommerce\Storage\AbstractStorage;
use App\Contract\Connector\Repository\StorageFullInterface;

class StorageStub extends AbstractStorage implements StorageFullInterface
{
    private array $entitiesState = [];

    public function __construct(
    )
    {

    }

    public function create(array $entitiesState): array
    {
        $this->entitiesState = array_merge($this->entitiesState, $entitiesState);
        return [];//todo
    }

    public function createOne(array $entityState): array
    {
        $this->entitiesState[] = $entityState;
        return [
            'id' => (string)random_int(1, 99999)
        ];//todo
    }

    public function fetch(int $start, int $end): array
    {
        return array_slice($this->entitiesState, $start, $end - $start);
    }

    public function fetchPage(int $page, int $pageSize): array
    {
        $res = array_slice($this->entitiesState, ($page - 1) * $pageSize, $pageSize);
        return $res;
    }

    public function __destruct()
    {
        file_put_contents(
            '/var/www/project/logs/result.txt',
            json_encode($this->entitiesState,
                JSON_PRETTY_PRINT)
        );
    }
}