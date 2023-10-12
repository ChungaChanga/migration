<?php

namespace App\Tests;

use App\Core\ConnectorInterface\Repository\RepositoryInterface;
use App\Core\ConnectorInterface\Repository\RepositoryReadInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AppBase extends KernelTestCase
{
    const REPOSITORY_SEVEN_VALUES = [
        'value1',
        'value2',
        'value3',
        'value4',
        'value5',
        'value6',
        'value7',
    ];

    protected function createReadRepository(array $values): RepositoryReadInterface
    {
        $repository = $this->createMock(RepositoryReadInterface::class);
        $repository->method('fetch')
            ->will($this->returnCallback(
                function ($start, $end) use ($values) {
                    return array_slice($values, $start, $end - $start);
                }
            ));
        return $repository;
    }

    protected function createRepository(array $values): RepositoryInterface
    {
        $storageValues = [];

        $repository = $this->createMock(RepositoryInterface::class);
        $repository->method('create')
            ->will($this->returnCallback(
                function (array $entities) use (&$storageValues) {
                    $storageValues = array_merge($storageValues, $entities);
                }
            ));
        $repository->method('fetch')
            ->will($this->returnCallback(
                function ($start, $end) use (&$storageValues) {
                    return array_slice($storageValues, $start, $end - $start);
                }
            ));

        return $repository;
    }
}