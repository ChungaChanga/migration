<?php

namespace App\Tests;

use App\ConnectorInterface\Repository\RepositoryReadInterface;
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

    protected function createRepository(array $values): RepositoryReadInterface
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
}